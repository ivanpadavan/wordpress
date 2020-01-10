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
          ymaps.ready(init);

          function init() {
              let coords = <?php echo json_encode($value->coords) ?> || [55.753994, 37.622093];
              const myMap = new ymaps.Map('map', {
                  center: coords,
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
                  ymaps.geocode(query)
                      .then((res) => {
                          var firstGeoObject = res.geoObjects.get(0);
                          console.log(firstGeoObject);

                          if (!firstGeoObject) {
                              myPlacemark.properties.set('iconCaption', 'Не найдено');
                              return;
                          }
                          coords = firstGeoObject.geometry._coordinates;
                          myPlacemark.geometry.setCoordinates(coords);
                          const [name, description] = ['name', 'text'].map(it => firstGeoObject.properties.get(it));
                          myPlacemark.properties
                              .set({ iconCaption: null, balloonContent: null });

                          const setByAddress = typeof query === 'string';

                          if (setByAddress) {
                              myMap.setCenter(coords);
                          }

                          const address = setByAddress
                              ? query
                              : description;
                          document.getElementById("<?php echo $field['id'] ?>").value = JSON.stringify({
                              coords,
                              address
                          });
                          document.getElementById("address").value = address;
                      }).catch(() => myPlacemark.properties.set('iconCaption', 'Ошибка'));
              }

              document
                  .getElementById('address')
                  .addEventListener('input', _.debounce(e => getAddress(e.target.value), 1000));
          }
      </script>
		<?php
	}
}
