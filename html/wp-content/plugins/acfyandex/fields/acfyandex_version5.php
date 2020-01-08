<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class acfyandex_version extends acfyandex_common {
	public function render_field( $field ) {
		$value = json_decode( $field['value'] );
		?>
      <input type="hidden" id="<?php echo $field['id'] ?>"
             name="<?php echo esc_attr( $field['name'] ) ?>"
             value="<?php echo esc_attr( $field['value'] ) ?>"
      />
      <label>
        Адрес
        <input type="text"
               id="address"
               value="<?php echo $value->address ?>"
        />
      </label>
      <div id="map" style="width: 100%; height: 250px"></div>
      <script type="text/javascript">
          var CallbackRegistry = {}; // реестр

          // при успехе вызовет onSuccess, при ошибке onError
          function scriptRequest(url, onSuccess, onError) {

              var scriptOk = false; // флаг, что вызов прошел успешно

              // сгенерировать имя JSONP-функции для запроса
              var callbackName = 'cb' + String(Math.random()).slice(-6);

              // укажем это имя в URL запроса
              url += ~url.indexOf('?') ? '&' : '?';
              url += 'callback=CallbackRegistry.' + callbackName;

              // ..и создадим саму функцию в реестре
              CallbackRegistry[callbackName] = function (data) {
                  scriptOk = true; // обработчик вызвался, указать что всё ок
                  delete CallbackRegistry[callbackName]; // можно очистить реестр
                  onSuccess(data); // и вызвать onSuccess
              };

              // эта функция сработает при любом результате запроса
              // важно: при успешном результате - всегда после JSONP-обработчика
              function checkCallback() {
                  if (scriptOk) return; // сработал обработчик?
                  delete CallbackRegistry[callbackName];
                  onError(url); // нет - вызвать onError
              }

              var script = document.createElement('script');

              // в старых IE поддерживается только событие, а не onload/onerror
              // в теории 'readyState=loaded' означает "скрипт загрузился",
              // а 'readyState=complete' -- "скрипт выполнился", но иногда
              // почему-то случается только одно из них, поэтому проверяем оба
              script.onreadystatechange = function () {
                  if (this.readyState == 'complete' || this.readyState == 'loaded') {
                      this.onreadystatechange = null;
                      setTimeout(checkCallback, 0); // Вызвать checkCallback - после скрипта
                  }
              }

              // события script.onload/onerror срабатывают всегда после выполнения скрипта
              script.onload = script.onerror = checkCallback;
              script.src = url;

              document.body.appendChild(script);
          }

          ymaps.ready(init);

          function init() {
              const center = [55.753994, 37.622093];
              let coords = <?php echo json_encode($value->coords) ?>;
              const myMap = new ymaps.Map('map', {
                  center,
                  zoom: 9,
                  controls: ['zoomControl']
              }, {
                  searchControlProvider: 'yandex#search'
              });

              const myPlacemark = createPlacemark(coords);
              myMap.geoObjects.add(myPlacemark);
              myPlacemark.events.add('dragend', function () {
                  getAddress(myPlacemark.geometry.getCoordinates());
              });

              myMap.cursors.push('arrow');
              // Слушаем клик на карте.
              myMap.events.add('click', function (e) {
                  coords = e.get('coords');
                  myPlacemark.geometry.setCoordinates(coords);
                  getAddress(coords);
              });

              // Создание метки.
              function createPlacemark(coords) {
                  return new ymaps.Placemark(coords, {}, {
                      preset: 'islands#redDotIconWithCaption',
                      draggable: true
                  });
              }

              // Определяем адрес по координатам (обратное геокодирование).
              function getAddress(query) {
                  myPlacemark.properties.set('iconCaption', 'поиск...');

                  scriptRequest(
                      `https://api-maps.yandex.ru/services/search/v2/?text=${query}&format=json&rspn=0&lang=ru_RU&apikey=<?php echo $this->YandexKey?>&token=34c03b8b52660f347dd9c178daf8cdcd&type=geo&properties=addressdetails&geocoder_sco=latlong&origin=jsapi2Geocoder`,
                      (res) => {
                          var firstGeoObject = res.data.features[0];

                          if (!firstGeoObject) {
                              myPlacemark.properties.set('iconCaption', 'Не найдено');
                              return;
                          }
                          coords = firstGeoObject.geometries[0].coordinates.reverse() || coords;
                          myPlacemark.geometry.setCoordinates(coords);
                          const {name, description} = firstGeoObject.properties;
                          myPlacemark.properties
                              .set({ iconCaption: null, balloonContent: null });

                          const setByAddress = typeof query === 'string';

                          if (setByAddress) {
                              myMap.setCenter(coords);
                          }

                          const address = setByAddress
                              ? query
                              : description + ', ' + name;
                          document.getElementById("<?php echo $field['id'] ?>").value = JSON.stringify({
                              coords,
                              address
                          });
                          document.getElementById("address").value = address;
                      },
                  )
              }

              document
                  .getElementById('address')
                  .addEventListener('input', _.debounce(e => getAddress(e.target.value), 1000));
          }
      </script>
		<?php
	}
}
