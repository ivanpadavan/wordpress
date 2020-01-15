jQuery(function ($) {
  xo_event_calendar_month = function (e, month, event, categories, holidays, prev, next, start_of_week, months, navigation) {
    var id = $(e).parents('.xo-event-calendar').attr('id');
    var target = $('#' + id);
    target.prop('disabled', true);
    target.addClass('xoec-loading');
    $.ajax({
      type: 'POST',
      url: xo_event_calendar_object.ajax_url,
      data: {
        'action': xo_event_calendar_object.action,
        'id': id,
        'month': month,
        'event': event,
        'categories': categories,
        'holidays': holidays,
        'prev': prev,
        'next': next,
        'start_of_week': start_of_week,
        'months': months,
        'navigation': navigation
      },
      datatype: 'html',
      success: function (response) {
        target.removeClass('xoec-loading');
        target.find(".xo-months").html(response);
      },
      error: function () {
      }
    });
    return false;
  };
});
