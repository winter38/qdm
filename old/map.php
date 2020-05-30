<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body>
<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (начало) -->
<div id="ymaps-map-container" style="width: 600px; height: 450px;">
</div>
<div style="width: 600px; text-align: right;">
  <a href="http://api.yandex.ru/maps/tools/constructor/?lang=ru-RU" target="_blank" style="color: #1A3DC1; font: 13px Arial,Helvetica,sans-serif;">Создано с помощью инструментов Яндекс.Карт</a>
</div>
<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU"></script>
<script type="text/javascript">
ymaps.ready(function() {
    var map = new ymaps.Map("ymaps-map-container", {
                            center: [37.530126869329834, 55.855458258811225],
                            zoom: 14, type: "yandex#map"});
    map.controls.add("zoomControl").add("mapTools").add(new ymaps.control.TypeSelector(["yandex#map",
                                                                                        "yandex#satellite",
                                                                                        "yandex#hybrid",
                                                                                        "yandex#publicMap"]));
    map.geoObjects.add(new ymaps.Placemark([37.53052174841734, 55.857498846063876],
                      {balloonContent: "125438, г. Москва, 4-й Лихачевский пер.,д. 15"},
                      {preset: "twirl#violetDotIcon"})).add(new ymaps.Polyline([[37.53033613968448, 55.85264670243416],
                      [37.529542205816064, 55.852888106991486],
                      [37.52720331955508, 55.8513913744598],
                      [37.52433318522478, 55.849539614551055],
                      [37.52140724604633, 55.84885154805982],
                      [37.52200806086567, 55.84588185761653]],
                      {balloonContent: "Маршрут автобуса (маршрутки) 123 от м. Водный стадион"},
                      {strokeColor: "00339a", strokeWidth: 5, strokeOpacity: 0.5})).add(new ymaps.Polyline([[37.50697475932253, 55.84755924155399],
                      [37.509706764632595, 55.85044087422541],
                      [37.51783274882448, 55.85300982515679],
                      [37.516178289434784, 55.85371239939357],
                      [37.51319609335831, 55.856106936515994],
                      [37.5222147866396, 55.86310229223655],
                      [37.5247897072939, 55.86184936410257]],
                      {balloonContent: "Маршрут автобуса (маршрутки) 65 от м. Водный стадион<br/>Ехать до остановки «Платформа Моссельмаш», далее пешком (показано голубым), до пурпурного пятнышка (Тензор-Телеком)"},
                      {strokeColor: "ff0000", strokeWidth: 5, strokeOpacity: 0.8})).add(new ymaps.Polyline([[37.530689565392535, 55.85307228589109],
                      [37.53227743312934, 55.85283088248273],
                      [37.541632978173304, 55.84631242118835],
                      [37.542448369713824, 55.84525004938342]],
                      {balloonContent: "маршрут автобуса (маршрутки) 123 от м. Петровско-Разумовская<br/>Ехать до остановки «Лихоборская набережная», далее пешком (показано голубым), до пурпурного пятнышка (Тензор-Телеком) (вне зависимости от того на какой станции метро сели в 123 автобус или маршрутку)<br/>"},
                      {strokeColor: "33cc00", strokeWidth: 5, strokeOpacity: 0.8})).add(new ymaps.Polyline([[37.525023727310995, 55.86158168659232],
                      [37.52485206593403, 55.861195525355654],
                      [37.5312035368813, 55.858419878043385],
                      [37.53111770619282, 55.85752680134703]],
                      {balloonContent: ""},
                      {strokeColor: "66c7ff", strokeWidth: 5, strokeOpacity: 0.8})).add(new ymaps.Polyline([[37.53110569685001, 55.85713606856632],
                      [37.53089112012883, 55.85409459500435],
                      [37.53037613599797, 55.853032436804355]],
                      {balloonContent: ""},
                      {strokeColor: "66c7ff", strokeWidth: 5, strokeOpacity: 0.8})).add(new ymaps.Polyline([[37.506010960788824, 55.84782052837728],
[37.50854296609888, 55.85088321945229],
[37.51748352701196, 55.853728393986366],
[37.526557922349006, 55.85421574340875],
[37.53016281126501, 55.85411918507944],
[37.530634880051636, 55.85754685822133]],
{balloonContent: "Проезд на автомобиле со стороны Кронштадского бульвара и со стороны Онежской улицы."},
{strokeColor: "004056", strokeWidth: 5, strokeOpacity: 0.8})).add(new ymaps.Polyline([[37.516674160899385, 55.853503418948414],
[37.518455147685295, 55.85241710385445], [37.52054142565066, 55.848744085976755],
[37.52131390184695, 55.84509832647939]],
{balloonContent: "Проезд на автомобиле со стороны Кронштадского бульвара и со стороны Онежской улицы."},
{strokeColor: "004056", strokeWidth: 5, strokeOpacity: 0.8}));});</script>
<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (конец) --> 
	</body>

	</html>
