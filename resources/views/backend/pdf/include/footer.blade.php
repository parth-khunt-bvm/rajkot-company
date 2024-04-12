
<footer>
    @if(isset($abbreviation))
    <div >
        <div>Abbreviation  List :
            @php
                $count = count($abbreviation);
                $i = 0 ;
            @endphp

            @foreach ($abbreviation as $key => $value)
                {{ $key }} = {{  $value }}
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
