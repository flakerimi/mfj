window.onload = function() {
  //<editor-fold desc="Changeable Configuration Block">

  // the following lines will be replaced by docker/configurator, when it runs in a docker-container
  window.ui = SwaggerUIBundle({
    url: "http://mfj.test/swagger.json",
    dom_id: '#swagger-ui',
    deepLinking: true,
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    presetsConfig: {
      TopbarPlugin: false,
      SwaggerUIStandalonePreset: {
        layout: "StandaloneLayout"
      }
    },
    layout: "StandaloneLayout"
  });

  //</editor-fold>
};
