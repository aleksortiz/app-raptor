const DataTableEvaluaciones = () => {
  return $("#evaluaciones-table").DataTable({
    ajax: {
      url: "/evaluaciones/datatable",
      type: "POST",
    },
    columns: [
      { data: "id" },
      { data: "usuario" },
      { data: "sucursal" },
      { data: "no_reporte" },
      { data: "entrada_id" },
      { data: "approved_by" },
      { data: "approved_at" },
    ],
  });
};

module.exports = {
  DataTableEvaluaciones,
};
