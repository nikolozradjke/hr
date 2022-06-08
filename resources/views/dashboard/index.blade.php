@extends('layouts.dashboard')

@section('content')

    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Type here...">
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
            @forelse($statuses as $status)
            <div class="col-2">
              <a href="" class="nav-link text-white font-weight-bold px-0">
                <span class="d-sm-inline d-none">{{ $status->title . ' (' . $status->candidates->count() . ')' }}</span>
              </a>
            </div>  
            @empty
            @endforelse
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Candidates</h6>
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
                        <p class="text-xs font-weight-bold mb-0">{{ $candidate->getStatus->title }}</p>
                      </td>
                      <td class="align-middle">
                        <a href="{{ route('editCandidates', $candidate->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
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
