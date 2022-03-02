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

    public function getAll() {
        return Finance::all();
    }

    public function getEntry($id) {
        return Finance::all();
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

    public function placeEntry($request) {
        return Finance::all();
    }

    public function updateEntry($request) {
        return Finance::all();
    }

    public function deleteEntry($id) {
        return Finance::all();
    }
}
