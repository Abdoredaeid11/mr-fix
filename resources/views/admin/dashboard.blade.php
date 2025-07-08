@extends('admin.layout.master')

@section('content')



        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">{{ __(key: 'message.Welcome') }}</h3>

              </div>

            </div>
<div class="row">
  <!-- الرئيسية -->
  <div class="col-sm-6 col-md-4">
    <div class="card card-stats card-round">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-primary bubble-shadow-small">
<i class="fas fa-id-card"></i> 
</div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <a href="{{ route('kyc.index') }}" class="card-category">{{ __(key: 'message.kyc') }}</a>
              <h4 class="card-title" id="count-kyc">{{ $kycs }}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- الطلبات -->
  <div class="col-sm-6 col-md-4">
    <div class="card card-stats card-round">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-info bubble-shadow-small">
              <i class="fas fa-file-invoice"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <a href="{{ route('request.index') }}" class="card-category">{{ __(key: 'message.requests') }}</a>
              <h4 class="card-title" id="count-requests">{{$orders}}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- الفنيين -->
  <div class="col-sm-6 col-md-4">
    <div class="card card-stats card-round">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-success bubble-shadow-small">
              <i class="fas fa-toolbox"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <a href="{{ route('worker.index') }}" class="card-category">{{ __(key: 'message.technicians') }}</a>
              <h4 class="card-title" id="count-workers">{{$workerCount}}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- العملاء -->
  <div class="col-sm-6 col-md-4">
    <div class="card card-stats card-round">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-secondary bubble-shadow-small">
              <i class="fas fa-users"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <a href="{{ route('user.index') }}" class="card-category">{{ __(key: 'message.clients') }}</a>
              <h4 class="card-title" id="count-users">{{$clientCount}}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- الخدمات -->
  <div class="col-sm-6 col-md-4">
    <div class="card card-stats card-round">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-warning bubble-shadow-small">
              <i class="fas fa-toolbox"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <a href="{{ route('specialization.index') }}" class="card-category">{{ __(key: 'message.services') }}</a>
              <h4 class="card-title">{{$specializationCount}}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- المناطق -->
  <div class="col-sm-6 col-md-4">
    <div class="card card-stats card-round">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-icon">
            <div class="icon-big text-center icon-danger bubble-shadow-small">
              <i class="fas fa-layer-group"></i>
            </div>
          </div>
          <div class="col col-stats ms-3 ms-sm-0">
            <div class="numbers">
              <a href="{{ route('category.index') }}" class="card-category">{{ __(key: 'message.categories') }}</a>
              <h4 class="card-title">{{$categoryCount}}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<div class="row mt-4">
    <!-- 🟩 الكارت الأيسر: أكثر العملاء -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                {{ __('message.top_clients') }}
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($topClients as $client)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $client->first_name }}
                            <span class="badge bg-light text-dark rounded-pill">
                                {{ $client->requests_as_client_count }} {{ __('message.requests') }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-center">
                            {{ __('message.no_data') }}
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- 🟦 الكارت الأوسط: أكثر الفنيين -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                {{ __('message.top_workers') }}
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($topWorkers as $worker)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $worker->first_name }}
                            <span class="badge bg-light text-dark rounded-pill">
                                {{ $worker->requests_as_provider_count }} {{ __('message.requests') }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-center">
                            {{ __('message.no_data') }}
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- 🟥 الكارت الأيمن: الفنيين المتأخرين -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                {{ __('message.late_workers') }}
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($lateWorkers as $worker)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $worker->first_name }}
                            <span class="badge bg-danger text-white rounded-pill">
                                {{ $worker->requestsAsProvider->count() }} {{ __('message.late_requests') }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-center">
                            {{ __('message.no_late_workers') }}
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>





  <!-- تسجيل الخروج -->

</div>




          </div>
        </div>

      <!-- Custom template | don't include it in your project! -->
      
<script>
document.addEventListener("DOMContentLoaded", function () {

    let previousCounts = {
        requests: parseInt(document.getElementById('count-requests').innerText),
        workers: parseInt(document.getElementById('count-workers').innerText),
        users: parseInt(document.getElementById('count-users').innerText),
        kyc: parseInt(document.getElementById('count-kyc').innerText)
    };

    function animateCount(element, start, end, duration = 1000) {
        let startTime = null;

        function update(timestamp) {
            if (!startTime) startTime = timestamp;
            const progress = Math.min((timestamp - startTime) / duration, 1);
            const current = Math.floor(progress * (end - start) + start);
            element.innerText = current;
            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                element.innerText = end;
            }
        }

        requestAnimationFrame(update);
    }

    function getAllCounts() {
        fetch("{{ route('dashboard.counts') }}")
            .then(response => response.json())
            .then(data => {
                for (let key in data) {
                    const newCount = data[key];
                    const element = document.getElementById('count-' + key);
                    if (element && newCount !== previousCounts[key]) {
                        animateCount(element, previousCounts[key], newCount, 800);
                        previousCounts[key] = newCount;
                    }
                }
            })
            .catch(error => {
                console.error("في مشكلة:", error);
            });
    }

    // كل 8 ثواني تحديث تلقائي
    setInterval(getAllCounts, 4000);

});
</script>



      
@endsection
