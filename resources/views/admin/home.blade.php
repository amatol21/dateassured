@php
    use App\Enums\ComplaintStatus;use App\Enums\VideoSessionStatus;use App\Helpers\Statistics;
    use App\Helpers\Svg;use App\Models\Complaint;
    use App\Enums\Gender;use App\Models\Config;use App\Models\VideoSession;

    $recentComplaints = Complaint::orderBy('id', 'desc')->limit(5)->get();
    $unresolvedComplaints = Complaint::orderBy('id', 'desc')
        ->where('status', '!=', ComplaintStatus::RESOLVED->value)->limit(5)->get();
    $totalCompletedEvents = VideoSession::where('status', VideoSessionStatus::DONE)->count();
    $totalUpcomingEvents = VideoSession::where('status', VideoSessionStatus::WAITING_FOR_START)->count();
    $completedEvents = VideoSession::where('status', VideoSessionStatus::DONE)->orderBy('started_at', 'desc')->limit(6)->get();
    $upcomingEvents = VideoSession::where('status', VideoSessionStatus::WAITING_FOR_START)
    ->orderBy('started_at', 'desc')->limit(6)->get();

    $load = function_exists('sys_getloadavg') ? sys_getloadavg() : [0, 0, 0];
    for ($i = 0; $i < count($load); $i++) $load[$i] = round($load[$i] * 100, 2);

    function getFormattedMemoryUsage() {
        $size = memory_get_usage(true);
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
@endphp

@extends('admin.index')

<style>
    .admin_widgets_3, .admin_widgets_2, .admin_widgets_1 {
        display: grid;
        gap: 1rem;
        width: 100%;
    }

    .admin_widgets_3 {
        grid-template-columns: repeat(auto-fill, minmax(15rem, 1fr));
    }

    .admin_widgets_2 {
        grid-template-columns: repeat(auto-fill, minmax(23rem, 1fr));
    }

    .admin_widgets_1 {
        grid-template-columns: repeat(auto-fill, minmax(40rem, 1fr));
    }

    .admin_widget {
        position: relative;
    }

    .admin_widget::before {
        content: '';
        display: block;
        width: 100%;
        padding-top: 60%;
    }
    .admin_widget.small::before {
        content: '';
        display: block;
        width: 100%;
        padding-top: 7%;
    }

    .admin_widget_title {
        position: absolute;
        left: 1rem;
        top: 1rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: #555555;
        width: 100%;
    }

    .admin_widget_chart-wrap {
        position: absolute;
        left: 0.5rem;
        top: 3rem;
        width: calc(100% - 1rem);
        height: calc(100% - 4rem);
    }

    .admin_widget_items {
        display: flex;
        flex-direction: column;
        padding: 1rem;
        position: absolute;
        left: 0;
        top: 2rem;
        height: calc(100% - 2rem);
        width: 100%;
    }

    .admin_widget_item {
        font-size: 0.75rem;
        border: 1px solid #bbb;
        border-radius: 0.25rem;
        height: 1.5rem;
        display: flex;
        align-items: center;
        padding: 0 0.5rem;
        text-decoration: none;
        color: #333;
        flex-shrink: 0;
    }

    .admin_widget_item + .admin_widget_item {
        margin-top: 0.25rem;
    }

    a.admin_widget_item:hover {
        border-color: #999;
    }
</style>

@section('adminContent')

    <script src="/js/chart.js"></script>

    <div class="admin_widgets_2">
        <div class="admin_widget pad">
            <div class="admin_widget_title">Registered Users
                ({{ Statistics::getTotalRegisteredUsersCount(Gender::MALE) }} male,
                {{ Statistics::getTotalRegisteredUsersCount(Gender::FEMALE) }} female)
            </div>
            <div class="admin_widget_chart-wrap">
                <canvas id="admin-ctx-total-reg" class="admin_widget_chart"></canvas>
            </div>
        </div>
        <div class="admin_widget pad">
            <div class="admin_widget_title">Payments</div>
        </div>
    </div>
    <div class="admin_widgets_3 mt-1">
        <div class="admin_widget pad">
            <div class="admin_widget_title">Recent Users Complaints</div>
            <div class="admin_widget_items">
                @foreach($recentComplaints as $complaint)
                    <a href="{{ route('admin.complaints.view', ['id' => $complaint->id], false) }}"
                       class="admin_widget_item">{{ $complaint->subject }}</a>
                @endforeach
            </div>
        </div>
        <div class="admin_widget pad">
            <div class="admin_widget_title">Unresolved Complaints</div>
            <div class="admin_widget_items">
                @foreach($unresolvedComplaints as $complaint)
                    <a href="{{ route('admin.complaints.view', ['id' => $complaint->id], false) }}"
                       class="admin_widget_item">{{ $complaint->subject }}</a>
                @endforeach
            </div>
        </div>
        <div class="admin_widget pad">
            <div class="admin_widget_title">Pending Queries</div>
        </div>
    </div>

    <div class="admin_widgets_2 mt-1">
        <div class="admin_widget pad">
            <div class="admin_widget_title">Completed Events ({{ $totalCompletedEvents }} total)</div>
            <div class="admin_widget_items">
                @foreach($completedEvents as $vs)
                    <a href="{{ route('admin.videoSessions', [], false) }}?name={{ $vs->id }}"
                       class="admin_widget_item">
                            <?= Svg::icon($vs->country, 18, 18, 14) ?> &nbsp;
                        #{{ $vs->id }} at {{ $vs->started_at }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="admin_widget pad">
            <div class="admin_widget_title">Upcoming Events ({{ $totalUpcomingEvents }} total)</div>
            <div class="admin_widget_items">
                @foreach($upcomingEvents as $vs)
                    <a href="{{ route('admin.videoSessions', [], false) }}?name={{ $vs->id }}"
                       class="admin_widget_item">
                            <?= Svg::icon($vs->country, 18, 18, 14) ?> &nbsp;
                        #{{ $vs->id }} at {{ $vs->started_at }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="admin_widgets_1 mt-1">
        <div class="admin_widget pad">
            <div class="admin_widget_title">Server Resources (Memory used: {{ getFormattedMemoryUsage() }})</div>
            <div class="admin_widget_chart-wrap">
                <canvas id="admin-ctx-sys-load" class="admin_widget_chart"></canvas>
            </div>
        </div>
    </div>
    <div class="admin_widgets_1 mt-1">
        <div class="admin_widget small pad">
            <div class="admin_widget_title">Maintenance</div>
            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center">
                @if(Config::getMaintenance() === null)
                    There is no maintenance at the moment.
                @else
                    Maintenance enabled to {{ Config::getMaintenance()->maintenance_to }} with message<br/>
                    <div style="padding: 0.75rem; background-color: #eee; border-radius: 0.5rem; margin-top: 0.5rem; max-width: 400px; font-size: 0.85rem">
                        {{ Config::getMaintenance()->maintenance_message }}
                    </div>
                @endif

                <form action="{{ route('admin.setMaintenance', [], false) }}"
                      id="maintenance-form"
                      method="POST" class="mt-1 mb-2">
                    @csrf

                    <label class="w-100">
                        <span class="label">Maintenance to</span>
                        <input type="datetime-local" name="to" class="input" required>
                        <span class="error" data-for="to"></span>
                    </label>

                    <label class="w-100 mt-1 flex column">
                        <span class="label">Message</span>
                        <textarea rows="10" name="message" class="input" required></textarea>
                        <span class="error" data-for="message"></span>
                    </label>

                    <button type="submit" class="btn btn-pink mt-1">Set maintenance</button>
                </form>

                <script>
                    (() => {
                        let form = document.getElementById('maintenance-form');
                        form.addEventListener('submit', async e => {
                            e.preventDefault();

                            try {
                                let res = await fetch(form.getAttribute('action'), {
                                    method: 'POST',
                                    body: new FormData(form)
                                });
                                if (res.ok) {
                                    alert('Maintenance has been set successfully');
                                    window.location.reload();
                                }
                            } catch (e) {
                                alert('There is error occurred during processing your request.');
                            }
                        });
                    })();
                </script>
            </div>
        </div>
    </div>

    <script>
        function showChartData(ctx, data) {
            if (typeof ctx === 'string') ctx = document.querySelector(ctx);

            let chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.male.map(i => Object.keys(i)[0]),
                    datasets: [
                        {
                            data: data.male.map(i => Object.values(i)[0]),
                            fill: {
                                target: 'origin',
                                above: 'rgba(156,200,234,0.33)',
                                below: 'rgb(0, 0, 255)'
                            },
                            borderColor: '#2894ec',
                            tension: 0.01
                        },
                        {
                            data: data.female.map(i => Object.values(i)[0]),
                            fill: {
                                target: 'origin',
                                above: 'rgba(234,156,233,0.33)',
                                below: 'rgb(255,0,234)'
                            },
                            borderColor: '#ec28e2',
                            tension: 0.01
                        },
                    ]
                },
                options: {
                    animation: false,
                    responsive: true,
                    aspectRatio: 2.25,
                    scales: {
                        y: {
                            beginAtZero: true,
                            display: true,
                            ticks: {
                                precision: 0
                            }
                        },
                        x: {
                            display: false,
                            ticks: {
                                callback: i => {
                                    return Date.parse(i + ' 23:59:59');
                                }
                            }
                        }
                    },
                    plugins: {
                        decimation: {
                            enabled: false
                        },
                        legend: {
                            display: false
                        }
                    }
                }
            });

            window.addEventListener('load', () => chart.resize());
        }

        let totalReg = {
            male: {!! json_encode(Statistics::getRegisteredUsersCount(10, Gender::MALE), JSON_PRETTY_PRINT) !!},
            female: {!! json_encode(Statistics::getRegisteredUsersCount(10, Gender::FEMALE), JSON_PRETTY_PRINT) !!}
        };
        showChartData('#admin-ctx-total-reg', totalReg);

        let chart = new Chart(document.getElementById('admin-ctx-sys-load'), {
            type: 'line',
            data: {
                labels: ['1 minute', '5 minutes', '15 minutes'],
                datasets: [
                    {
                        label: 'CPU usage',
                        data: {{ json_encode($load) }},
                        fill: {
                            target: 'origin',
                            above: 'rgba(156,200,234,0.33)',
                            below: 'rgb(0, 0, 255)'
                        },
                        borderColor: '#2894ec',
                        tension: 0.01
                    },
                ]
            },
            options: {
                animation: false,
                responsive: true,
                aspectRatio: 2.25,
                scales: {
                    y: {
                        beginAtZero: true,
                        display: true,
                    },
                }
            }
        });
    </script>

@endsection
