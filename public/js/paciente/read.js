$(document).ready(function() {

    let testUrl = Routing.generate('server_processing');
   
  

    var table = $('#mydatatable').DataTable({
        language: {
            url: '/datatables/js/Spanish.json'
        },
  
        responsive: true,
        ordering: false,
        processing: true,
        stateSave: true,
        serverSide: true, 

        lengthMenu: [
            [5, 10, 25],
            [5, 10, 25],
        ],
        ajax: {
            url: testUrl,
            type:'GET'
        },
        columnDefs: [
            { name: "Nombre", targets: 0},
            { name: "Apellido", targets: 1 },
            { name: "cedula", targets: 2 },
            { name: "Sexo", targets: 3 },
            { name: "Fecha Nacimiento", targets: 4,
            "render": function (data) {
                var date = new Date(data);
                var month = date.getMonth() + 1;
                return (month.toString().length > 1 ? month : "0" + month) + "-" + date.getDate() + "-" + date.getFullYear();
            }
        },
            { name: "Fecha Ingreso", targets: 5,
            "render": function (data) {
                var date = new Date(data);
                var month = date.getMonth() + 1;
                return (month.toString().length > 1 ? month : "0" + month) + "-" + date.getDate() + "-" + date.getFullYear();
            }
        },
            { name: "Imagen", targets: 6,
            render: function ( data, type, row ) {
                return '<img  src="'+ data + '" height="55px">';
                }
        },
            { name: "id", targets: 7,  render: (data, type, row ) => {
                
                return `<button class="AddCard btn btn-success btn-sm"><i class="fa-solid fa-address-card"></i></button>
                <button class="taskEditBtn btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="fa-solid fa-pen-to-square"></i></button>
                <button class="task-delete btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                `;
                ;  
                
         }
        
        },  
        ],

      
        "initComplete": function () {
            this.api().columns().every( function () {
                
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                        }
                });
            })
        },


        
        

    });

  var tableRow = {};
  $(document).on('click', '.AddCard', function () {
      tableRow = table.row($(this).parents('tr')).data();
      id= tableRow[7];
      let route = Routing.generate('app_consulta_new', {'id': 'fileId_'});
      route = route.replace('fileId_', id);
      window.location.href = route;   
  });

 $('tfoot').each(function () {
    $(this).insertAfter($(this).siblings('thead'));
});



});
