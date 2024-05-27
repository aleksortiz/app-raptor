const { DataTableEvaluaciones } = require("./datatable");
const { EvaluacionesImages } = require("./fileinput");
const { addFileComponent, removeFileComponent } = require("./addFileComponent");

let evaluacionesTable = null;

const refreshDataTableEvaluaciones = () => {
  evaluacionesTable = evaluacionesTable
    ? evaluacionesTable.ajax.reload(null, false)
    : DataTableEvaluaciones();
};

document.getElementById("create-evaluacion").addEventListener("click", () => {
  EvaluacionesImages();
});

document.getElementById("addFile").addEventListener("click", () => {
  addFileComponent();
});

removeFileComponent();
refreshDataTableEvaluaciones();
