@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    var totalHabitacionesInput = document.getElementById("total_habitaciones");
    var numeroHabitacionesNewInput = document.getElementById("numero_habitaciones_new");

    totalHabitacionesInput.addEventListener("input", function () {
        var nuevoValor = totalHabitacionesInput.value;
        numeroHabitacionesNewInput.value = nuevoValor;
    });
});
</script>
@endsection
