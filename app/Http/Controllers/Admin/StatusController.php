<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::paginate(10);
        return view('admin.statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('admin.statuses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:statuses,slug',
        ]);

        $data = $request->all();
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        Status::create($data);

        return redirect()
            ->route('admin.statuses.index')
            ->with('success', 'Статус добавлен');
    }

    public function edit(Status $status)
    {
        return view('admin.statuses.edit', compact('status'));
    }

    public function update(Request $request, Status $status)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:statuses,slug,' . $status->id,
        ]);

        $data = $request->all();
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $status->update($data);

        return redirect()
            ->route('admin.statuses.index')
            ->with('success', 'Статус обновлён');
    }

    public function destroy(Status $status)
    {
        $status->delete();

        return redirect()
            ->route('admin.statuses.index')
            ->with('success', 'Статус удалён');
    }
}