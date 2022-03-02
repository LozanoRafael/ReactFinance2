<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;

class FinanceController extends Controller
{
    //
    public function test() {
        return Finance::all();
    }

    public function getAll(Request $request) {
        $perPage = 10;
        $search = $request->query('search');
        $datefrom = $request->query('datefrom');
        $dateto = $request->query('dateto');
        $page = $request->query('page');
        $queries = [
            'search' => $search,
            'datefrom' => $datefrom,
            'dateto' => $dateto,
            'page' => $page
        ];
        // var_dump($queries);
        $q = Finance::where('user_id', auth()->user()->id);
        if (empty($search) === false) {
            // $q->where('name', 'LIKE', '%'.$search.'%');
            // $q->orWhere('group', 'LIKE', '%'.$search.'%');
            $q->where(function ($query) use ($search) {
                $query->where('name', "like", "%" . $search . "%");
                $query->orWhere('group', "like", "%" . $search . "%");
            });
        }
        if (empty($datefrom) === false) {
            // var_dump(date('Y-m-d H:i:s', strtotime($datefrom)));
            $q->whereDate('date', '>=', date('Y-m-d H:i:s', strtotime($datefrom)));
        }
        if (empty($dateto) === false) {
            $q->whereDate('date', '<=', date('Y-m-d H:i:s', strtotime($dateto)));
        }
        $q->orderBy('id', 'DESC');

        $forCredit = clone $q;
        $forDebit = clone $q;

        $data = $q->get();

        $totalCredit = $forCredit->where('type', '=', 'credit')->sum('amount');
        $totalDebit = $forDebit->where('type', '=', 'debit')->sum('amount');

        $paginatedData = $q->paginate($perPage);

        // var_dump($data);
        // var_dump($paginatedData);
        $pageCount = (int) ceil(count($data)/$perPage);
        // var_dump($pageCount);
        $itemsInPage = count($paginatedData);
        // var_dump($pageCount);


        // if ($datefrom)
        // $q->whereDate('date')
        return [
            'data' => $paginatedData,
            'itemsCurrentPage' => $itemsInPage,
            'pages' => $pageCount,
            'totalCredit' => $totalCredit,
            'totalDebit' => $totalDebit
        ];
    }

    public function getEntry($id) {
        return Finance::find($id);
    }

    public function getEntriesCount() {
        return Finance::all();
    }

    public function getPages() {
        // With Search and Filter
        return Finance::all();
    }

    public function getEntriesOfPage() {
        // With Search and Filter
        return Finance::all();
    }

    private function filterRequest(Request $request) {
        $user = auth()->user()->id;
        $type = $request->type === 'credit' ? 'credit' : 'debit';
        $date = empty($request->date) === false ? $request->date : date('Y-m-d H:i:s');
        $name = empty($request->name) === false ? $request->name : '';
        $group = empty($request->group) === false ? $request->group : '';
        $amount = empty($request->amount) === false ? $request->amount : 0;
        // var_dump($date);
        return [
            'user_id' => $user,
            'date' => date('Y-m-d H:i:s', strtotime($date)),
            'group' => $group,
            'name' => $name,
            'type' => $type,
            'amount' => $amount,
        ];
    }

    public function placeEntry(Request $request) {
        $data = $this->filterRequest($request);

        Finance::create($data);
        echo 'Entry entered';
        return $data;
    }

    public function updateEntry(Request $request) {
        $data = $this->filterRequest($request);

        $finance = Finance::find($request->id);
        if ($finance->user_id != auth()->user()->id) {
            return response([
                'message' => 'Unauthorized Update'
            ], 401);
        }
        $finance->date = date('Y-m-d H:i:s', strtotime($data['date']));
        $finance->group = $data['group'];
        $finance->name = $data['name'];
        $finance->type = $data['type'];
        $finance->amount = $data['amount'];
        $finance->save();

        echo 'Entry updated';
        return $data;
    }

    public function deleteEntry(Request $request) {
        $finance = Finance::find($request->id);
        if ($finance->user_id != auth()->user()->id) {
            return response([
                'message' => 'Unauthorized Delete'
            ], 401);
        }
        $finance->delete();
        echo 'Entry deleted';
        return $request->id;
    }
}
