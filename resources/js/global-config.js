require("./es");

$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  },
});

$.extend(true, $.fn.dataTable.defaults, {
  responsive: true,
  destroy: true,
  processing: true,
  serverSide: true,
  language: {
    url: "/lang/es.json",
  },
  lengthMenu: [
    [10, 25, 50, -1],
    [10, 25, 50, "Todos"],
  ],
});
