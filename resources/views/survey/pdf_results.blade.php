<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hasil Survei - {{ $survey->title }}</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 20px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 14px;
            color: #666;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .stat-box {
            display: table-cell;
            width: 25%;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #eee;
            text-align: center;
        }
        .stat-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #888;
            font-weight: bold;
        }
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            margin-top: 5px;
        }
        .question-card {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .question-header {
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .question-title {
            font-size: 14px;
            font-weight: bold;
        }
        .question-type {
            font-size: 10px;
            background-color: #eee;
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .option-row {
            margin-bottom: 8px;
        }
        .option-label {
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        .progress-bar {
            height: 10px;
            background-color: #eee;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background-color: #4f46e5;
        }
        .text-answer {
            font-size: 11px;
            padding: 8px;
            background-color: #f8f9fa;
            border: 1px solid #eee;
            margin-bottom: 5px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $survey->title }}</div>
        <div class="subtitle">Laporan Hasil Survei - Dicetak pada {{ now()->format('d F Y H:i') }}</div>
    </div>

    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-label">Total Responden</div>
            <div class="stat-value">
                {{ $survey->respondents->count() }}
                @if($survey->max_respondents)
                    <span style="font-size: 12px; color: #888">/ {{ $survey->max_respondents }}</span>
                @endif
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Status</div>
            <div class="stat-value">{{ $survey->is_active ? 'Aktif' : 'Nonaktif' }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Periode</div>
            <div class="stat-value" style="font-size: 12px">
                {{ $survey->start_date->format('d/m/y') }} - {{ $survey->end_date->format('d/m/y') }}
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label">OPD</div>
            <div class="stat-value" style="font-size: 12px">{{ $survey->opd->singkatan }}</div>
        </div>
    </div>

    @foreach($results as $result)
        <div class="question-card">
            <div class="question-header">
                <span class="question-type">{{ str_replace('_', ' ', $result['type']) }}</span>
                <div class="question-title" style="margin-top: 5px">
                    {{ $loop->iteration }}. {{ $result['text'] }}
                </div>
            </div>

            @if(in_array($result['type'], ['single_choice', 'multiple_choice', 'rating']))
                @foreach($result['data'] as $data)
                    <div class="option-row">
                        <div class="option-label">
                            <span style="float: left">{{ $data['label'] }}</span>
                            <span style="float: right; font-weight: bold">{{ $data['count'] }} ({{ $data['percentage'] }}%)</span>
                            <div style="clear: both"></div>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $data['percentage'] }}%"></div>
                        </div>
                    </div>
                @endforeach

                @if($result['type'] === 'rating' && isset($result['average_rating']))
                    <div style="margin-top: 15px; padding-top: 10px; border-top: 1px dashed #eee">
                        <span style="font-weight: bold">Rata-rata Rating:</span>
                        <span style="font-size: 18px; font-weight: bold; color: #d97706">{{ $result['average_rating'] }} / 5</span>
                    </div>
                @endif
            @else
                <div style="font-size: 10px; text-transform: uppercase; color: #888; margin-bottom: 5px">10 Jawaban Terbaru:</div>
                @forelse($result['data'] as $text)
                    <div class="text-answer">{{ $text }}</div>
                @empty
                    <div style="font-style: italic; color: #888; font-size: 11px">Belum ada jawaban teks.</div>
                @endforelse
            @endif
        </div>
    @endforeach
</body>
</html>
