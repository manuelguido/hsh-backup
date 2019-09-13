<div class="uns">
    @php
        //La funcion random y su respectivo if son a modo de ejemplo. cambiar por datos de la BD
        $points2 = $points = rand(0,5) + rand(1,10) / 10;
        if ($points > 5) {
            $points2 = $points = 5;
        }else if ($points < 1) {
            $points2 = $points = 0;
        }
        $count = 0;
        if ($points > 4) {
            $checked = 'text-success';
        }else if($points >= 2.5){
            $checked = 'text-warning';
        }else if($points >= 1){
            $checked = 'text-danger';   
        }else {
            $checked = '';
        }

    @endphp
    @if ($points2 === 0)

        @for ($i=0; $i < 5; $i++)
            <span class="fa fa-star gray-disabled {{ $checked }}"></span>
        @endfor

    @else

        @while ($points >= 1)
            <span class="fa fa-star {{ $checked }}"></span>
                @php 
                    $count++;
                    $points--;
                @endphp
            @endwhile
            
            @if ($count < 5 and $points > 0)
            
            <span class="fas fa-star-half-alt {{ $checked }}"></span>
                @php 
                    $count++
                @endphp
            @endif
            @while ($count < 5)
                <span class="far fa-star {{ $checked }}"></span>
                @php
                    $count++
                @endphp
            @endwhile   

        <span class="{{ $checked }}">
            @php if ($points2 != 0) {
                //Funcion de cast-> int to float
                echo number_format($points2,1);
            }
            @endphp
        </span>

        @endif

</div>