<template>
<div class="weather-page">
    <div class="select-city">
        <button><span class="city">{{ city }}</span><span class="ok">Ок</span></button>
    </div>
        <label class="switch">
            <input type="checkbox" v-model="deg" @change="change">
            <span class="bg"></span>
            <span class="cel">C</span>
            <span class="far">F</span>
        </label>
    <div class="weather">
        <div class="weather-main">
            <img class="weather-icon" :src="icon" alt="">
            <div class="weather-degree">
                {{ temp }}º
            </div>
        </div>
        <div class="weater-condition">
            {{ condition }}
        </div>
    </div>
    <div class="description-container">
        <div class="desscription-inner">
            <div class="description-col wind_speed">
                <div>Ветер</div>
                <div>{{ wind_speed }} м/c, {{ wind_dir }}</div>
            </div>
            <div class="description-col pressure_mm">
                <div>Давление</div>
                <div>{{ pressure_mm }} мм рт. ст.</div>
            </div>
            <div class="description-col humidity">
                <div>Влажность</div>
                <div>{{ humidity }} %</div>
            </div>
            <div class="description-col humidity">
                <div>Влажность</div>
                <div>{{ humidity }} %</div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
function windToRu(en){
    const dict = {
        nw: "северо-западное",
        n: "северное",
        ne: "северо-восточное",
        e: "восточное",
        se: "юго-восточное",
        s: "южное",
        sw: "юго-западное",
        w: "западное",
        с: "штиль"
    }
    return dict[en];
}
function condToRu(en){
    const dict = {
        "clear" : "ясно",
        "partly-cloudy" : "малооблачно",
        "cloudy" : "облачно с прояснениями",
        "overcast" : "пасмурно",
        "partly-cloudy-and-light-rain" : "небольшой дождь",
        "partly-cloudy-and-rain" : "дождь",
        "overcast-and-rain" : "сильный дождь",
        "overcast-thunderstorms-with-rain" : "сильный дождь, гроза",
        "cloudy-and-light-rain" : "небольшой дождь",
        "overcast-and-light-rain" : "небольшой дождь",
        "cloudy-and-rain" : "дождь",
        "overcast-and-wet-snow" : "дождь со снегом",
        "partly-cloudy-and-light-snow" : "небольшой снег",
        "partly-cloudy-and-snow" : "снег",
        "overcast-and-snow" : "снегопад",
        "cloudy-and-light-snow" : "небольшой снег",
        "overcast-and-light-snow" : "небольшой снег",
        "cloudy-and-snow" : "снег",
    }
    return dict[en];
}
function cToF(c){
    return c * 9 / 5 + 32;
}
function fToC(f){
    return (f - 32)  * 5 / 9;
}
    export default {
        data() {
            return {
                lon: "38.975313",
                lat: "45.035470",
                city: "Краснодар",
                temp: '',
                condition: '',
                wind_speed: '',
                wind_dir: '',
                pressure_mm: '',
                humidity: '',
                icon: '',
                deg: true,
            }
        },
        mounted() {
            fetch('/api/weather',
                {
                    method: "POST",
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        lat: this.lat,
                        lon: this.lon
                    })
                }
            ).
            then( result => {
                result.json().then( data => {
                    if(!this.deg){
                        this.temp = cToF(data.fact.temp);
                    } else {
                        this.temp = data.fact.temp;
                    }
                    this.condition = condToRu(data.fact.condition);
                    this.wind_speed = data.fact.wind_speed;
                    this.wind_dir = windToRu(data.fact.wind_dir);
                    this.pressure_mm = data.fact.pressure_mm;
                    this.humidity = data.fact.humidity;
                    this.icon = 'https://yastatic.net/weather/i/icons/blueye/color/svg/' + data.fact.icon + '.svg';
                    console.log(data);
                });
            })
        },
        methods: {
            change: function() {
                if(this.deg){
                    this.temp = fToC(this.temp);
                } else {
                    this.temp = cToF(this.temp);
                }
            }
        }
    }
</script>
