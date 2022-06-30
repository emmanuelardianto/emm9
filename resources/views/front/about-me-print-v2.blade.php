<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>emmanuel_cv</title>

    <!-- Bootstrap -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic:wght@400;700&display=swap" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    body {
        color: #3D3D3D;
        font-family: 'Nanum Gothic', sans-serif;
        font-size: 12px;
        margin: 0;
        padding: 0;
    }
    .text-gray {
        color: #bdc3c7;
    }
    
    .text-right {
        text-align: right;
    }
    .float-left{
        float: left;
    }
    .left-title {
        width: 20%; 
        text-align: right; 
        padding: 0 5px;
        float: left;
    }
    .right-content {
        width: 70%; 
        border-left: 1px solid #bdc3c7; 
        padding: 0 5px;
        float: left;
    }
    .title {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 1.1em;
        margin-bottom: 5px;
    }
    .sub-title {
        font-weight: bold;
    }
    p {
        line-height: 1.4em;
    }
    .section {
        margin-bottom: 15px;
    }
    ul {
        padding-left: 15px;
        margin: 0;
    }
    ul li {
        line-height: 1.4em;
    }
    @media print {
        .lang-item span, .light-border {
            -webkit-print-color-adjust: exact; 
        }
    }
    .lang-item span {
        width: 15px;
        display: inline-block;
        background: #3D3D3D;
        border-radius: 50%;
        margin: 0 3px;
    }
    .lang-item span.gray {
        background: #DEDEDE;
    }
    .company, .grade, .skill-title {
        font-weight: bold;
    }
    .job-title, .institution {
        font-weight: bold;
        color: #3D3D3D;
    }
    .mb-1 {
        margin-bottom: 10px;
    }
    .mb-05 {
        margin-bottom: 5px;
    }
    </style>
  </head>
  <body>
    <div>
        <div style="margin-bottom: 10px;">
            <h1 style="font-size: 2.5em; margin: 0; text-transform: uppercase; font-weight: normal;">Emmanuel Sitinjak/<small style="font-size: 0.5em;">Software Engineer</small></h1>
        </div>
        <div class="section">
            <div class="title">About Me /</div>
            <div class="content">
                I have 8+ years experience in software development with a demonstrated history of working in the B2C and B2B retail industry. Skilled in analysis, UML Design, Front End Development and UI/UX. Strong in technical and product management professional with a Bachelor focused in Information Technology.
            </div>
        </div>
        <div class="float-left" style="width: 26%; margin-right: 4%;">
            <div class="section">
                <div class="title">Contact /</div>
                <div class="content">
                    <div>surabi.eman@gmail.com</div>
                    <div>+81 80 3503 2875</div>
                    <div>http://emmards.me/</div>
                </div>
            </div>
            <div class="section">
                <div class="title">Educations /</div>
                <div class="content">
                    @foreach(config('about-me.education')['en'] as $key => $value)
                    <div class="mb-05">
                        <div style="font-weight: bold;">{{$value['grade']}}</div>
                        <div class="institution">{{$value['institution']}}</div>
                        <div class="date">{{$value['date']}}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="section">
                <div class="title">Languages /</div>
                <div class="content">
                    @foreach(config('about-me.language') as $key => $value)
                    <div class="job-item">
                        <div class="lang-item mb-05">
                            {{$value['name']}} 
                            <div style="display: none;">
                                @for($i=0;$i<$value['value'];$i++)
                                    <span>&nbsp;</span>
                                @endfor
                                @for($i=0;$i < 4-$value['value'];$i++)
                                    <span class="gray">&nbsp;</span>
                                @endfor
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="mb-1" style="clear: both;"></div>
                </div>
            </div>
            <div class="section">
                <div class="title">Skills /</div>
                <div class="content">
                @foreach(config('about-me.skills') as $key => $value)
                    <div class="mb-05">
                        <div style="font-weight: bold;">{{$value['title']}}</div>
                        <ul>
                        @foreach($value['items'] as $subkey => $subvalue)
                            <li>{{$subvalue}}</li>
                        @endforeach
                        </ul>
                    </div>
                @endforeach
                </div>
            </div>
            <div class="section">
                <div class="title">Hobbies /</div>
                <div class="content">
                    <div>
                        Music, Photography, Sports, Coffee, Games.
                    </div>
                </div>
            </div>
            
        </div>
        <div class="float-left" style="width: 70%;">
            <div class="section">
                <div class="title">Work Experiences /</div>
                <div class="content">
                    @foreach(config('about-me.work-experiences') as $key => $value)
                        @if($value['visibility'])
                        <div class="job-item">
                            <div class="company">{{$value['employer']}}</div>
                            <div class="type-of-business mb-05">{{$value['type_of_business']}}</div>
                            @foreach($value['positions'] as $key => $positions)
                            <div class="mb-1">
                                <div class="job-title">{{$positions['position']}} ({{$positions['date']}})</div>
                                <div class="mb-05">
                                    Responsibilities : <br />{{$positions['responsibilities']}}
                                </div>
                                @if (count($positions['project']) > 0)
                                    <div>Projects :</div>
                                    <ul class="mb-05">
                                        {{count($positions['project']) == 0 ? '-' : ''}}
                                        @foreach($positions['project'] as $subkey => $subvalue)
                                        <li>{{$subvalue}}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if (isset($positions['development']))
                                <div>Development Stack : <br /> {{$positions['development']}} </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            
            <div class="section" style="display: none;">
                <div class="title">Freelance Works</div>
                @foreach(config('about-me.freelance') as $key => $platform)
                <div class="sub-title mb-05">{{ $key }}</div>
                <div class="content mb-1">
                    <ul>
                    @foreach($platform as $key => $value)
                        <li class="mb-05">
                            <div style="font-weight: bold;">{{ $value['project'] }}</div>
                            <div class="mb-05">
                                <div>{{$value['description']}}</div>
                                <div>{{$value['stack']}}</div>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
            
            {{-- 
            <div class="section">
                <div class="title">Certificates</div>
                <div class="content">
                @foreach(config('about-me.certificate') as $key => $value)
                <div style="padding: 5px 0;">
                    <div class="lang-item">
                        <div style="font-weight: bold;">{{$value['name']}}</div>
                        <div style="padding: 3px 0;">
                            <div>{{$value['date']}}</div>
                            <div>Score : {{$value['score']}}</div>
                        </div>
                    </div>
                </div>
                @endforeach
                </div>
            </div>
            --}}
        </div>
    </div>
</body>
</html>