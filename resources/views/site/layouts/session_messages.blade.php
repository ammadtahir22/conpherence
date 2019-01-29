@if (session('msg-success'))
    <div class="row"><div class="col-md-12">
            <p style="    margin-top: 5px;" class="alert alert-success" role="alert">
                {{ session('msg-success') }}
            </p>
        </div>
    </div>
@endif

@if (session('msg-error'))
    <div class="row"><div class="col-md-12">
            <p style="    margin-top: 5px;" class="alert alert-danger" role="alert">
                {{ session('msg-error') }}
            </p>
        </div>
    </div>

@endif

@if ($errors->any())
    <div class="row"><div class="col-md-12">
            <p style="    margin-top: 5px;" class="alert alert-danger" role="alert">
                {{ $errors->first() }}
            </p>
        </div>
    </div>

@endif

<div id="flash_massage">

</div>