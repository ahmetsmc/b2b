z = document.querySelectorAll("[data-choices]"), Array.from(z).forEach(function (e) {
    var t = {}, a = e.attributes;
    a["data-choices-groups"] && (t.placeholderValue = "This is a placeholder set in the config"), a["data-choices-search-false"] && (t.searchEnabled = !1), a["data-choices-search-true"] && (t.searchEnabled = !0), a["data-choices-removeItem"] && (t.removeItemButton = !0), a["data-choices-sorting-false"] && (t.shouldSort = !1), a["data-choices-sorting-true"] && (t.shouldSort = !0), a["data-choices-multiple-remove"] && (t.removeItemButton = !0), a["data-choices-limit"] && (t.maxItemCount = a["data-choices-limit"].value.toString()), a["data-choices-limit"] && (t.maxItemCount = a["data-choices-limit"].value.toString()), a["data-choices-editItem-true"] && (t.maxItemCount = !0), a["data-choices-editItem-false"] && (t.maxItemCount = !1), a["data-choices-text-unique-true"] && (t.duplicateItemsAllowed = !1), a["data-choices-text-disabled-true"] && (t.addItems = !1), a["data-choices-text-disabled-true"] ? new Choices(e, t).disable() : new Choices(e, t)
}), z = document.querySelectorAll("[data-provider]"), Array.from(z).forEach(function (e) {
    var t, a, n;
    "flatpickr" == e.getAttribute("data-provider") ? (n = e.attributes, (t = {}).disableMobile = "true", n["data-date-format"] && (t.dateFormat = n["data-date-format"].value.toString()), n["data-enable-time"] && (t.enableTime = !0, t.dateFormat = n["data-date-format"].value.toString() + " H:i"), n["data-altFormat"] && (t.altInput = !0, t.altFormat = n["data-altFormat"].value.toString()), n["data-minDate"] && (t.minDate = n["data-minDate"].value.toString(), t.dateFormat = n["data-date-format"].value.toString()), n["data-maxDate"] && (t.maxDate = n["data-maxDate"].value.toString(), t.dateFormat = n["data-date-format"].value.toString()), n["data-deafult-date"] && (t.defaultDate = n["data-deafult-date"].value.toString(), t.dateFormat = n["data-date-format"].value.toString()), n["data-multiple-date"] && (t.mode = "multiple", t.dateFormat = n["data-date-format"].value.toString()), n["data-range-date"] && (t.mode = "range", t.dateFormat = n["data-date-format"].value.toString()), n["data-inline-date"] && (t.inline = !0, t.defaultDate = n["data-deafult-date"].value.toString(), t.dateFormat = n["data-date-format"].value.toString()), n["data-disable-date"] && ((a = []).push(n["data-disable-date"].value), t.disable = a.toString().split(",")), n["data-week-number"] && ((a = []).push(n["data-week-number"].value), t.weekNumbers = !0), flatpickr(e, t)) : "timepickr" == e.getAttribute("data-provider") && (a = {}, (n = e.attributes)["data-time-basic"] && (a.enableTime = !0, a.noCalendar = !0, a.dateFormat = "H:i"), n["data-time-hrs"] && (a.enableTime = !0, a.noCalendar = !0, a.dateFormat = "H:i", a.time_24hr = !0), n["data-min-time"] && (a.enableTime = !0, a.noCalendar = !0, a.dateFormat = "H:i", a.minTime = n["data-min-time"].value.toString()), n["data-max-time"] && (a.enableTime = !0, a.noCalendar = !0, a.dateFormat = "H:i", a.minTime = n["data-max-time"].value.toString()), n["data-default-time"] && (a.enableTime = !0, a.noCalendar = !0, a.dateFormat = "H:i", a.defaultDate = n["data-default-time"].value.toString()), n["data-time-inline"] && (a.enableTime = !0, a.noCalendar = !0, a.defaultDate = n["data-time-inline"].value.toString(), a.inline = !0), flatpickr(e, a))
}), Array.from(document.querySelectorAll('.dropdown-menu a[data-bs-toggle="tab"]')).forEach(function (e) {
    e.addEventListener("click", function (e) {
        e.stopPropagation(), bootstrap.Tab.getInstance(e.target).show()
    })
});

function showLoader(element = "body") {
    $(element).addClass('loader');
}

function hideLoader(element = "body") {
    $(element).removeClass('loader');
}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Fancybox.bind('[data-fancybox]');

    hideLoader();

    $(document).on('click', '.delete-confirm-action', function (event) {
        event.preventDefault();
        var href = $(this).attr('href');

        Swal.fire({
            html: '<div class="mt-3">' +
                '<lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>' +
                '<div class="mt-4 pt-2 fs-15 mx-5">' +
                '<h4>Silmek istediğinize emin misiniz?</h4>' +
                '<p class="text-muted mx-4 mb-0">Bu kaydı sildikten sonra geri alamasınız, silmek istediğinize emin misiniz?</p></div>' +
                '</div>',
            showCancelButton: !0,
            customClass: {
                confirmButton: "btn btn-danger w-xs me-2 mb-1",
                cancelButton: "btn btn-primary w-xs mb-1"
            },
            confirmButtonText: "Evet, kaldır",
            buttonsStyling: !1,
            showCloseButton: !0,
            cancelButtonText: "İptal",
        }).then((result) => {
            window.location.href = href;
        })
    })

    $('form:not(.no-loader)').submit(function () {
        showLoader();
    });
});


$(document).on("ajaxStart", function () {
    showLoader();
});

$(document).on("ajaxComplete", function (event, xhr, settings) {
    var excepts = [];

    var isExcept = false;

    excepts.forEach(function (except) {
        if (settings.url.includes(except)) {
            isExcept = true;
        }
    });

    if (!isExcept) {
        hideLoader();
    }

    if (xhr.status === 500 || xhr.status === 403) {
        var texts = xhr.status === 500
            ? $('meta[name="general-error-texts"]').attr('content')
            : $('meta[name="forbidden-error-texts"]').attr('content');

        if (texts) {
            texts = JSON.parse(texts);
            Swal.fire({
                icon: "error",
                title: texts.title,
                text: texts.description,
                confirmButtonText: texts.button,
                customClass: {
                    confirmButton: "btn btn-primary",
                }
            });
        }
    }
});

$(document).ajaxError(function (event, jqxhr, settings, thrownError) {
    if (jqxhr.status === 403) {
        if (jqxhr.responseJSON.message) {
            notify('error', jqxhr.responseJSON.message);
        }
    }
});
