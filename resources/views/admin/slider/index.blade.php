@extends('layouts.panel.index')
@section('title', 'Slider')
@section('content')

<h1>Slider</h1>

<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="mt-4">
                <table id="example" class="table">
                    <thead class="fw-normal">
                        <tr>
                            <th>No</th>
                            <th scope="col">Page ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image URL</th>
                            <th scope="col">Position</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="" style="vertical-align: middle">
                        @foreach ($slider as $row)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ \App\Models\Page::find($row->page_id)->nama_page ?? 'N/A' }}</td>
                                <td>{{ $row->title }}</td>
                                <td>{{ $row->description }}</td>
                                <td>{{ $row->image_url }}</td>
                                <td>{{ $row->position }}</td>
                                <td>{{ $row->status == 'active' ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                            id="dropdownMenuButton{{ $row->id_slider }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-bars"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $row->id_slider }}">
                                            <li><a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#edit{{ $row->id_slider }}"><i
                                                        class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                            <li>
                                                <form action="{{ route('slider.destroy', $row->id_slider) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fa-regular fa-trash-can pe-none"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Insert Modal -->
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="addLabel">Add Slider</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('slider.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page ID</label>
                        <select class="form-select" name="page_id" aria-label="Default select example" required>
                            <option selected>Pilih ...</option>
                            @foreach ($page as $row)
                                <option value="{{ $row->id_page }}">{{ $row->nama_page }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" style="height:150px" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image URL</label>
                        <input type="text" class="form-control" name="image_url" id="image_url" required>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="number" class="form-control" name="position" id="position" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                        <div>
                            <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success rounded-3 text-white">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modals -->
<!-- Edit Modals -->
@foreach ($slider as $row)
<div class="modal modal-lg fade" id="edit{{ $row->id_slider }}" tabindex="-1" aria-labelledby="edit{{ $row->id_slider }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="edit{{ $row->id_slider }}Label">Edit Slider</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('slider.update', $row->id_slider) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page ID</label>
                        <select class="form-select" name="page_id" aria-label="Default select example" required>
                            @foreach ($page as $element)
                                <option value="{{ $element->id_page }}" {{ $element->id_page == $row->page_id ? 'selected' : '' }}>
                                    {{ $element->nama_page }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ $row->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" style="height:150px" name="description">{{ $row->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image URL</label>
                        <input type="text" class="form-control" name="image_url" id="image_url" value="{{ $row->image_url }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="number" class="form-control" name="position" id="position" value="{{ $row->position }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ $row->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $row->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                        <div>
                            <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success rounded-3 text-white">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


@endsection
