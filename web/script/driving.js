$(document).ready(function () {

    var lanes = {};
    var cars = {};
    var roadLength = 0;

    var colors = [
        'red',
        'black',
        'green',
        'blue',
        'orange',
    ];

    function addOrUpdateLane(lane, road) {
        let uuid = lane.uuid;

        if (!(uuid in lanes)) {
            lanes[uuid] = {};
        }

        lanes[uuid]['x'] = lane.startLocation.x;
        lanes[uuid]['y'] = lane.startLocation.y;
        lanes[uuid]['dir'] = lane.direction;
        lanes[uuid]['len'] = road.len;

        roadLength = road.len;
    }

    function addOrUpdateCar(car) {
        let uuid = car.uuid;
        if (!(uuid in cars)) {
            cars[uuid] = {};
            //random car color
            cars[uuid]['color'] = colors[Math.floor(Math.random() * colors.length)];
        }

        cars[uuid]['x'] = car.location.x;
        cars[uuid]['y'] = car.location.y;
    }

    function removeNonExistingCars(newCars) {
        for (const [uuid, car] of Object.entries(cars)) {
            let found = false
            newCars.forEach((newCar, i) => {
                if (newCar.uuid === uuid) {
                    found = true;
                }
            });

            if (!found) {
                delete(cars[uuid]);
                $('.' + uuid).remove();
            }
        }
    }
    
    function render() {
        let cityWidth = $('#city').width();
        let cityHeight = $('#city').height();

        for (const [uuid, lane] of Object.entries(lanes)) {
            let laneDiv = $('.' + uuid);

            if (!laneDiv[0]) {
                laneDiv = $('#lanes').append('<div class="lane ' + uuid + '"></div>');
            }

            let x = lane.x;
            if (lane.dir === 0) {
                x = cityWidth * (1 - lane.x / roadLength);
            }
            let y = lane.y * 5 + cityHeight / 2;
            let width = cityWidth;

            laneDiv.css('left', x);
            laneDiv.css('top', y);
            laneDiv.css('width', width);
        }

        for (const [uuid, car] of Object.entries(cars)) {
            let carDiv = $('.' + uuid);

            if (!carDiv[0]) {
                carDiv = $('#cars').append('<div class="car ' + uuid + '"></div>');
            }

            let x = car.x / roadLength * cityWidth;
            let y = car.y * 5 + cityHeight / 2;

            carDiv.css('left', x);
            carDiv.css('top', y);
            carDiv.css('background-color', car.color);
        }
    }

    function connect() {
        var socket = new WebSocket('ws://localhost:8000');

        socket.addEventListener('error', (err) => {
            setTimeout(function () {
                connect();
            }, 1000);
        });

        socket.addEventListener('open', (data) => {
            console.log('Connection established!');

            socket.onmessage = function(e) {
                console.log(e.data);

                data = JSON.parse(e.data);

                data.road.lanes.forEach(function (lane, i) {
                    addOrUpdateLane(lane, data.road);
                });

                removeNonExistingCars(data.transport);

                data.transport.forEach(function (car, i) {
                    addOrUpdateCar(car);
                });

                render();
                /*
                {
                    "road":{
                        "len":600,
                        "startLocation":{"x":0,"y":0},
                        "lanes":[
                            {
                                "uuid":"572b21bc-bc63-42d8-acf0-8c662860729a",
                                "width":5,
                                "direction":0,
                                "startLocation":{"x":600,"y":0}
                            }, {
                                "uuid":"6e8164fa-fbab-41d4-843b-957de44f77b3",
                                "width":5,
                                "direction":1,
                                "startLocation":{"x":0,"y":0}
                            }
                        ]
                    },
                    "transport":[
                        {
                            "uuid":"bada367b-47b0-436f-a5a8-e900e9d7e533",
                            "speed":60,
                            "location":{"x":0,"y":0},
                            "laneUuid":"6e8164fa-fbab-41d4-843b-957de44f77b3"
                        }, {
                            "uuid":"805f91a1-bfe2-48cb-a469-1029bfb2da65",
                            "speed":60,
                            "location":{"x":0,"y":0},
                            "laneUuid":"572b21bc-bc63-42d8-acf0-8c662860729a"
                        }
                    ]
                }
                */

            };

            socket.onclose =  function (e) {
                console.log('Connection closed!');
            }

            setInterval(function () {
                socket.send('getMovementPattern')
            }, 1000);
        });
    }





    connect();

});