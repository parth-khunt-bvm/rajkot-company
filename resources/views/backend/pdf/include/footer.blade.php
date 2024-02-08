
<footer>
    @if(isset($abbreviation))
    <div >
        <div>Abbreviation  List :
            @php
                $count = count($abbreviation);
                $i = 0 ;
            @endphp

            @foreach ($abbreviation as $key)
                {{ $key['short_name'] }} = {{  $key['full_name'] }}
                @php
                    $i++;
                @endphp
                @if($i != $count)
                    ,
                @endif

            @endforeach

        </div>
      </div>
      @endif
</footer>
