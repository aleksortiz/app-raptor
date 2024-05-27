const addFileComponent = () => {
  axios.get("/evaluaciones/addFileComponent").then(({ data }) => {
    $("#file-component").append(data);

    removeFileComponent();
  });
};

const removeFileComponent = () => {
  $(".btn-remove").on("click", function (e) {
    e.preventDefault();
    $(this.parentNode.parentNode).remove();
  });
};

module.exports = {
  addFileComponent,
  removeFileComponent,
};
