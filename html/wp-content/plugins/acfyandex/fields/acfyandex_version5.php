<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class acfyandex_version extends acfyandex_common {
	public function render_field( $field ) {
		$value = json_decode( $field['value'] );
	  $value->icon ??= 'islands#redStretchyIcon';
		?>
      <input type="hidden" id="<?php echo $field['id'] ?>"
             name="<?php echo esc_attr( $field['name'] ) ?>"
             value="<?php echo esc_attr( $field['value'] ) ?>"
      />

      <label>
        Тип метки
        <select id="icon"></select>
      </label>

      <label>
        Адрес
        <input type="text"
               id="address"
               value="<?php echo $value->address ?>"
        />
      </label>

      <div id="map" style="width: 100%; height: 250px"></div>
      <script type="text/javascript">
          const fieldValueEl = document.getElementById("<?php echo $field['id'] ?>")
          function updateFieldValue(val) {
              fieldValueEl.value = JSON.stringify(
                  Object.assign(JSON.parse(fieldValueEl.value) || {}, val),
              );
          }
          ymaps.ready(init);
          ymaps.ready();

          function makeTypeSelectable(placemark) {
              const icons = Object.keys(ymaps.option.presetStorage.hash)
                  .filter(it => it.startsWith('islands') && it.endsWith('Icon'));
              const select = document.getElementById('icon');
              const fragment = document.createDocumentFragment();
              for (const type of icons) {
                  const el = document.createElement('option');
                  el.innerText = type;
                  el.value = type;
                  if (type === '<?php echo $value->icon ?>') {
                      console.log(type);
                      el.selected = true;
                  }
                  fragment.appendChild(el);
              }
              select.appendChild(fragment);

              select.addEventListener(
                  'input',
                  e => {
                      const icon = e.target.value;
                      placemark.options.set('preset', icon);
                      updateFieldValue({ icon });
                  }
              );
          }

          function init() {
              let coords = <?php echo json_encode( $value->coords ) ?> ||[55.753994, 37.622093];
              const myMap = new ymaps.Map('map', {
                  center: coords,
                  zoom: 9,
                  controls: ['zoomControl']
              }, {
                  searchControlProvider: 'yandex#search'
              });

              const myPlacemark = createPlacemark(coords);
              makeTypeSelectable(myPlacemark);
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
                      preset: '<?php echo $value->icon ?>',
                      draggable: true
                  });
              }

              // Определяем адрес по координатам (обратное геокодирование).
              function getAddress(query) {
                  myPlacemark.properties.set('iconCaption', 'поиск...');
                  ymaps.geocode(query)
                      .then((res) => {
                          const firstGeoObject = res.geoObjects.get(0);

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

                          updateFieldValue({ address, coords });
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
