<div style="@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap'); font-family: 'Cairo', sans-serif;background-color: #eeeeef; padding: 50px 0; ">
    <div style="max-width:640px; margin:0 auto; ">
        <div style="color: #fff; text-align: center; background-color:#33333e; padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0;">
            {{-- <img src="https://event.ayham.info/dashboard/assets/media/logos/logo-with-orange.png" width="100" alt="Logo"> --}}
            <h1>{{__('Sahab Booking Details')}} {{$booking_id}}</h1>
        </div>
        <div style="padding: 20px; background-color: rgb(255, 255, 255);">
            <p style="">
                <span style="color: rgb(85, 85, 85); font-size: 14px;">{{__('Your booking has been successfully confirmed')}}.</span>
                <span style="color: rgb(85, 85, 85); font-size: 14px;">{{__('Thank you for choosing our service')}}.</span><br>
            </p>
            <p style=""><br></p>
            <p style="">
                <span style="color: rgb(85, 85, 85); font-size: 14px;">{{__('Your Booking Details')}}:</span><br>
                {{-- <span style="color: rgb(85, 85, 85); font-size: 14px;">{{__('title')}}: </span><br> --}}
                {{-- @foreach($seats as $seat) --}}
                    {{-- <span style="color: rgb(85, 85, 85); font-size: 14px;">{{$seat['seat_id']}}</span><br> --}}
                <span style="color: rgb(85, 85, 85); font-size: 14px;">{{__('Title')}}: {{$title}}</span><br>
                {{-- @endforeach --}}
                <span style="color: rgb(85, 85, 85); font-size: 14px;">{{__('Starting Date')}}: {{$starting_date}}</span><br>
                <span style="color: rgb(85, 85, 85); font-size: 14px;">{{__('Ending Date')}}: {{$ending_date}}</span><br>
                <span style="color: rgb(85, 85, 85); font-size: 14px;">{{__('Payment')}}: {{$payment}}</span><br>
                {{-- <span style="color: rgb(85, 85, 85); font-size: 14px;">{{__('Event Time')}}: {{$event_time}}</span><br> --}}
            </p>
            <p style=""><br></p>
            {{-- <div style="text-align: center; margin-top: 20px;">
                <a href="#"><img src="https://event.ayham.info/dashboard/assets/media/svg/social/instagram.svg" alt="Instagram"></a>
                <a href="#"><img src="https://event.ayham.info/dashboard/assets/media/svg/social/tiktok.svg" alt="Tiktok"></a>
                <a href="#"><img src="https://event.ayham.info/dashboard/assets/media/svg/social/facebook.svg" alt="Facebook"></a>
            </div> --}}
        </div>
    </div>
</div>
