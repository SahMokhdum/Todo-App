<!DOCTYPE html>
<html lang="en">

<head>
  <title>{{ __('To-Do-List') }}</title>
      <!-- favicon -->
	<link rel="icon"  type="image/x-icon" href="{{asset('assets/favicon.ico')}}"/>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/fonts.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>

  <div class="container mt-100 plr-250">
    <h2 class="text-center flarge mb-3">{{ __('Todos') }}</h2>
  <form id="todo-form" action="{{ route('todo.store') }}" method="post">
      {{ csrf_field() }}
      <div class="input-group" id="myinput">
        <div class="input-group-prepend">
          <span class="input-group-text ns"><i id="icn" class="fas fa-chevron-down {{ count($todos) == 0 ? 'd-none' : '' }}"></i></span>
        </div>
        <input type="text" id="data" name="name" class="form-control" placeholder="{{ __('What needs to be done?') }}" required>
      </div>
    </form>
  <div id="content" class="{{ count($todos) == 0 ? 'd-none' : '' }}">
      <table id="mytable" class="table table-bordered mb-0">
        <tbody id="todos">
          @foreach($todos as $todo)
          <tr class="sects">
            <td>  
              <div class="round">
                <input type="checkbox" class="checkers" data-check="{{ route('todo.status',['id1' => $todo->id, 'id2' => 1]) }}" data-uncheck="{{ route('todo.status',['id1' => $todo->id, 'id2' => 0]) }}" id="checkbox{{ $todo->id }}" {{ $todo->is_completed == 1 ? 'checked' : '' }} />
                <label for="checkbox{{ $todo->id }}"></label>
              </div>
              <div class="text-el ml-4">
                <span class="txt {{ $todo->is_completed == 1 ? 'strikeout' : '' }}">{{ $todo->name }}</span>
              </div>
              <span data-href="{{ route('todo.delete',$todo->id) }}" class="float-right delete d-none">X</span>
              <div class="medit d-none">
               <form class="edit-form" action="{{ route('todo.update',$todo->id) }}" method="post">
                  {{ csrf_field() }}
                <input type="text" name="name" class="form-control edt">
              </form>
              </div>
            </td>
          </tr>
          @endforeach


        </tbody>
        <tfoot>

          <tr class="footer">
            <td class="text-center">
              <span class="float-left">
                <span id="cnt">{{ count($todos) }}</span> {{ __('item(s) left') }}
              </span>
            <span class="mr-3 all option active" data-state="all" data-href="{{ route('todo.showAll') }}">
                {{ __('All') }}
              </span>
              <span class="mr-3 aactive option" data-state="aactive" data-href="{{ route('todo.showActive') }}">
                {{ __('Active') }}
              </span>
              <span class="mr-3 cmplt option" data-state="cmplt" data-href="{{ route('todo.showCompleted') }}">
                {{ __('Completed') }}
              </span>
            <span class="float-right ml-5 ccmplt {{ $completed == 0 ? 'd-none' : '' }}" data-href="{{ route('todo.clear') }}">
                {{ __('Clear completed') }}
              </span>
          </tr>


        </tfoot>
      </table>
      <div class="ml-1 mr-1 b-1"></div>
      <div class="ml-2 mr-2 b-1"></div>
    </div>
  </div>

  <script src="{{ asset('assets/js/jquery.js') }}"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>