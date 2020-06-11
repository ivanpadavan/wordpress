<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class acfyandex_version extends acfyandex_common {
	public function render_field( $field ) {
		$value = json_decode( $field['value'] );
		$value->icon ??= 'islands#redChristianCircleIcon';
		?>
      <input type="hidden" id="<?php echo $field['id'] ?>"
             name="<?php echo esc_attr( $field['name'] ) ?>"
             value="<?php echo esc_attr( $field['value'] ) ?>"
      />

      <label>
        Иконка
        <select id="icon"></select>
      </label>
      <label>
        Цвет
        <select id="color"></select>
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
              console.log(JSON.parse(fieldValueEl.value, undefined, 2));
          }

          ymaps.ready(init);
          ymaps.ready();

          function constructPreset(color, icon) {
              return `islands#${color}${icon[0].toUpperCase() + icon.slice(1)}CircleIcon`
          }

          function extract(preset, isColor) {
              const sanitized = preset.slice(8, -10);
              for (var i = sanitized.length - 1; i >= 0; i--) {
                  if (sanitized[i].toUpperCase() === sanitized[i]) {
                      return isColor ? sanitized.slice(0, i) : sanitized.slice(i).toLowerCase();
                  }
              }
          }

          function makeTypeSelectable(placemark) {
              let pictograms = new Set();
              const hashes = Object.values(ymaps.option.presetStorage.hash);
              for (let hash of hashes) {
                  const p = hash.iconPictogram;
                  if (p && p === p.toLowerCase() && !p.match(/[0-9]+/)) {
                      pictograms.add(hash.iconPictogram);
                  }
              }
              pictograms = [...pictograms].sort();
              const colors = ["blue", "red", "darkOrange", "night", "darkBlue", "pink", "gray", "brown", "darkGreen", "violet", "black", "yellow", "green", "orange", "lightBlue", "olive", "grey", "darkorange", "darkgreen", "darkblue", "lightblue"];

              function populateChoices(element, choices, isColor) {
                const fragment = document.createDocumentFragment();
                for (const type of choices) {
                    const el = document.createElement('option');
                    el.innerText = type;
                    el.value = type;
                    if (type === extract('<?php echo $value->icon ?>', isColor)) {
                        el.selected = true;
                    }
                    fragment.appendChild(el);
                }
                element.appendChild(fragment);
              }

              console.log(extract('<?php echo $value->icon ?>', true));
              console.log(extract('<?php echo $value->icon ?>', false));

              const iconSelect = document.getElementById('icon');
              const colorSelect = document.getElementById('color');

              populateChoices(iconSelect, pictograms, false);
              populateChoices(colorSelect, colors, true);

              function setPreset(preset) {
                 placemark.options.set('preset', preset);
                 updateFieldValue({ icon: preset });
              }

             iconSelect.addEventListener('input', e => setPreset(constructPreset(colorSelect.value, e.target.value)));
             colorSelect.addEventListener('input', e => setPreset(constructPreset(e.target.value, iconSelect.value)));
          }

          function init() {
              let coords = <?php echo json_encode( $value->coords ) ?> ||
              [55.753994, 37.622093];
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
                              .set({iconCaption: null, balloonContent: null});

                          const setByAddress = typeof query === 'string';

                          if (setByAddress) {
                              myMap.setCenter(coords);
                          }

                          const address = setByAddress
                              ? query
                              : description;

                          updateFieldValue({address, coords});
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
