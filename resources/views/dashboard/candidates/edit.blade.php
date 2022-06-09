@extends('layouts.dashboard')

@section('content')

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header pb-0">
              
            </div>
            <div class="card-body">
              <p class="text-uppercase text-sm">Edit Candidate</p>
              <hr class="horizontal dark">
              <div class="row">
              @if(Session::has('error'))
              <div class="alert alert-danger">
                {{ Session::get('error')}}
              </div>
              @endif
              @if($errors->any())
                  <div>
                      <p><strong>Opps Something went wrong</strong></p>
                      <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                      </ul>
                  </div>
              @endif
                <form method="POST" action="{{ route('updateCandidates', $item->id) }}" enctype="multipart/form-data">
                @csrf
                @forelse($fields as $field)
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">
                      {{ $field }}
                      {{ $field == 'skills' ? '(PHP, MYSQL)' : '' }}
                    </label>
                    @if($field == 'cv')
                    <input class="form-control" type="file" name="{{ $field }}">
                    @if($item->cv)
                      <a href="{{ $item->cv }}">CV</a>
                    @endif
                    @elseif($field == 'status')
                    <select name="{{ $field }}" class="form-control" disabled>
                      @forelse($statuses as $status)
                      <option value="{{ $status->id }}" {{ $status->id == $item->status ? 'selected' : '' }}>{{ $status->title }}</option>
                      @empty
                      @endforelse
                    </select>
                    @elseif($field == 'skills')
                    <input class="form-control" type="text" name="{{ $field }}" value="{{ old($field) }}">
                    @if($item->skills)
                    @foreach(json_decode($item->skills) as $skill)
                    <label class="checkbox-inline">
                        <input type="checkbox" 
                                value="{{ $skill }}" 
                                name="itemSkills[]"
                                checked
                        >
                        {{ $skill }}
                    </label>
                    @endforeach
                    @endif
                    @else
                    <input class="form-control" type="text" name="{{ $field }}" value="{{ $item->$field }}">
                    @endif
                  </div>
                </div>
                @empty
                @endforelse
                <div class="d-flex align-items-center">
                  <button type="submit" class="btn btn-primary btn-sm ms-auto">Update</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-profile">
            <div class="card-body pt-0">
              <div class="text-center mt-4">
                <h3>
                  Timeline
                </h3>
                @forelse($item->timelines as $timeline)
                <div class="h6 font-weight-300">
                  <p>
                    {{ $timeline->status . ' - ' . $timeline->comment }}
                  </p>
                  <p>
                    {{ strftime( '%e %b %Y' , strtotime($item->created_at)) }}
                  </p>
                  <hr>
                </div>
                @empty
                @endforelse
              </div>
              <form action="{{ route('storeCandidateTimeline', $item->id) }}" method="POST">
                @csrf
                <div class="form-group">
                  <select name="timeline_status" class="form-control">
                    @forelse($statuses as $status)
                    <option value="{{ $status->id }}" {{ $status->id == $item->status ? 'selected disabled' : '' }}>{{ $status->title }}</option>
                    @empty
                    @endforelse
                  </select>
                </div> 
                <div class="form-group">
                    <label for="comment" class="form-control-label">
                      Comment
                    </label>
                  <textarea class="form-control" name="comment" rows="4"></textarea>
                </div> 
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-sm ms-auto">Add</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection
