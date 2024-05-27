const EvaluacionesImages = () => {
  $("#evaluaciones-images")
    .fileinput({
      language: "es",
      removeFromPreviewOnError: true,
      showBrowse: false,
      showUpload: false,
      showCaption: false,
      browseOnZoneClick: true,
      resizeImage: true,
      maxImageWidth: 1366,
      maxImageHeight: 800,
      resizePreference: "width",
      allowedFileExtensions: ["jpg", "png", "gif", "pdf", "jfif"],
      previewFileIconSettings: {
        jpg: '<i class="fa fa-file-photo-o text-warning"></i>',
        pdf: '<i class="fa fa-file-pdf-o text-danger"></i>',
      },
    })
    .on("filezoomshow", () => $("#modal-form-evaluaciones").modal("toggle"))
    .on("filezoomhidden", () => $("#modal-form-evaluaciones").modal("toggle"));
};

module.exports = {
  EvaluacionesImages,
};
