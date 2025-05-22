document.getElementById("uber-button").addEventListener("click", function () {
    const destino = this.name; 
    const destinoCodificado = encodeURIComponent(destino);

    if ("geolocation" in navigator) {
      navigator.geolocation.getCurrentPosition(
        function (position) {
          const latitude = position.coords.latitude;
          const longitude = position.coords.longitude;

          const url = `https://m.uber.com/ul/?action=setPickup&pickup[latitude]=${latitude}&pickup[longitude]=${longitude}&dropoff[formatted_address]=${destinoCodificado}`;

          window.location.href = url;
        },
        function (error) {
          let mensagem = "Erro ao obter localização.";
          switch (error.code) {
            case error.PERMISSION_DENIED:
              mensagem = "Permissão de localização negada.";
              break;
            case error.POSITION_UNAVAILABLE:
              mensagem = "Localização indisponível.";
              break;
            case error.TIMEOUT:
              mensagem = "Tempo excedido para obter localização.";
              break;
          }
          alert(mensagem);
        },
        { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
      );
    } else {
      alert("Geolocalização não é suportada neste navegador.");
    }
  });