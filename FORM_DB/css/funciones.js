function show(mensaje){
  const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false, // Cambia a false para ocultar el botón de confirmación
      timer: 3000,
      timerProgressBar: false,
      didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
      }
  });

  Toast.fire({
      icon: "success", // Cambia el icono a "success"
      title: mensaje
  });
}
