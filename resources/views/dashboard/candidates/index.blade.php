@extends('layouts.dashboard')

@section('content')

    <div class="container-fluid py-4">
      <div class="row">
            <form action="" method="GET" class="form-control">
              <div class="input-group col-6">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="keyword" value="{{ request()->get('keyword') ? request()->get('keyword') : '' }}" placeholder="Type here...">
              </div>
              <div class="input-group">
                <label for="from">
                  From
                  <input type="date" name="from" class="form-control">
                </label>
              </div>
              <div class="input-group">
                <label for="to">
                  To
                  <input type="date" name="to" class="form-control">
                </label>
              </div>
              <div class="input-group">
                <button type="submit" class="btn btn-primary btn-sm ms-auto">Search</button>
              </div>
            </form>
            
            <div class="col-6">
              <form action="" method="get" class="form-control">
                <select name="status" class="form-control">
                  <option value="{{ false }}">All ({{ $count }})</option>
                @forelse($statuses as $status)
                  <option value="{{ $status->id }}" {{ request()->get('status') && request()->get('status') == $status->id ? 'selected' : '' }}>{{ $status->title . ' (' . $status->candidates_count . ')' }}</option>
                @empty
                @endforelse
                </select>
                <button type="submit" class="btn btn-primary btn-sm ms-auto">Search</button>
              </form>
            </div>
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Recruitment Pipeline</h6>
            </div>
            <div class="d-flex align-items-center">
              <a href="{{ route('createCandidates') }}" class="btn btn-primary btn-sm ms-auto">Add</a>
            </div>
            @if(Session::has('success'))
            <div class="alert alert-success">
              {{ Session::get('success')}}
            </div>
            @endif
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Full name</th>  
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Contact</th>  
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Experience</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Skills</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Salary range</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  @forelse($candidates as $candidate)
                    <tr>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $candidate->first_name . ' ' . $candidate->last_name }}</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $candidate->email . ', ' .$candidate->phone }}</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $candidate->experience }}</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">
                          <?php 
                            $skills = '';
                            if($candidate->skills){
                              foreach(json_decode($candidate->skills) as $skill){
                                $skills .= $skill . ' ';
                              }
                            }
                          ?>
                          {{ $skills }}
                        </p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $candidate->salary_range }}</p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $candidate->status_title }}</p>
                      </td>
                      <td class="align-middle">
                        <a href="{{ route('editCandidates', $candidate->id) }}" class="btn btn-primary btn-sm ms-auto" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                        <form action="{{ route('removeCandidates', $candidate->id) }}" method="post">
                        @csrf
                          <button type="submit" class="btn btn-warning btn-sm ms-auto">Remove</button>
                        </form>
                      </td>
                    </tr>
                    @empty
                    @endforelse  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection
