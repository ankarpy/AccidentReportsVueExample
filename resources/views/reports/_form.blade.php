@csrf
<div class="form-group">
    <span>Report Title</span>
    <input type="text" name="title" value="{{ old('title', $report->title) }}" id="report-title"
           class="form-field {{ $errors->has('title') ? 'is-invalid' : '' }}" placeholder="Summarize the report">


</div>
@if ($errors->has('title'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('title') }}</strong>
    </div>
@endif
<div class="form-group">
    <textarea name="body" id="report-body" rows="10" class="form-field {{ $errors->has('body') ? 'is-invalid' : '' }}"
              placeholder="Describe the incident">{{ old('body', $report->body) }}</textarea>


</div>
@if ($errors->has('body'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('body') }}</strong>
    </div>
@endif

<div class="form-group">
    <span>Vehicle Id</span>
    <input name="vehicle_id" rows="10" class="form-field {{ $errors->has('vehicle_id') ? 'is-invalid' : '' }}"
           placeholder="The vehicle which was involved in the accident"
           value="{{ old('vehicle_id', $report->vehicle_id) }}">


</div>
@if ($errors->has('vehicle_id'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('vehicle_id') }}</strong>
    </div>
@endif

<div class="form-group">
    <span>Injured Count</span>
    <input name="injured_count" rows="10" class="form-field {{ $errors->has('injured_count') ? 'is-invalid' : '' }}"
           placeholder="The number of passengers involved in the accident"
           value="{{ old('injured_count', $report->injured_count) }}">


</div>
@if ($errors->has('injured_count'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('injured_count') }}</strong>
    </div>
@endif

<div class="form-group">
    <span>Date of Accident</span>
    <b-form-datepicker id="example-datepicker" v-model="happenedAt"
                       name="happened_at"
                       class="mb-2 form-field {{ $errors->has('happened_at') ? 'is-invalid' : '' }}"
                       value="{{ old('happened_at', $report->happened_at) }}"
                       :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                       locale="en"></b-form-datepicker>


</div>
@if ($errors->has('happened_at'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('happened_at') }}</strong>
    </div>
@endif


<div class="form-group">
    <button type="submit"
            class="btn btn-outline-primary btn-lg">{{ isset($report->id) ? 'Update report' : 'Create report' }}</button>
</div>
