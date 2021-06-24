
<div class="container">
  <div class="row">  
    <div class="col-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">
              @can('admin')
                Selecionar
              @else
                Status
              @endcan
            </th>
            <th scope="col">Nome</th>
            <th scope="col">Tipo</th>
            <th scope="col">Nota</th>
            <th scope="col">Crédito</th>
            <th scope="col">Carga horária</th>
            <th scope="col">Código USP</th>
            <th scope="col">Ementa</th>
            <th scope="col">Comentários</th>
            @if($pedido->status != "Em elaboração")
            <th scope="col" style="display: none;"></th>
            @else
            <th scope="col">Excluir Disciplina</th>
            @endif

          </tr>
        </thead>
        <tbody>
          @foreach($pedido->disciplinas->sortBy('tipo') as $disciplina)  
          <tr>
            <td>
                @can('admin')
                  @if( $disciplina->status == "Análise" )
                    <input type="checkbox" name="disciplinas[]" value="{{ $disciplina->id }}">
                  @else
                    <i>{{ $disciplina->status }}</i>
                  @endif
                @else
                    <i>{{ $disciplina->status }}</i>
                    @if($disciplina->status == 'Indeferido')
                      (<a href="/disciplinas/{{ $disciplina->id }}/edit">solicitar revisão</a>)
                    @endif
                @endcan
            </td>
            <td>{{ $disciplina->nome }}</td>
            <td>{{ $disciplina->tipo }}</td>
            <td>{{ $disciplina->nota }}</td>
            <td>{{ $disciplina->creditos }}</td>
            <td>{{ $disciplina->carga_horaria }}</td>
            <td>{{ $disciplina->codigo }}</td>
            <td>
                @if($disciplina->tipo =="Obrigatória")
                <a href="/disciplinas/{{ $disciplina->id }}/showfile"><i class="far fa-file-pdf"></i></a> 
                @endif
            </td>
            <td>
                @foreach($disciplina->statuses as $status)
                  @if(!empty($status->reason))
                    {{-- TODO: Colocar data do comentário e deixar colapsado --}}
                    {{ \App\Models\User::find($status->user_id)->name }}: {{ $status->reason }}
                  @endif
                @endforeach
            </td>
            @if($pedido->status == "Em elaboração")
            <td>
              <form method="POST" action="/disciplinas/{{$disciplina->id}}"> 
                  @csrf
                  @method('delete')
              <button type="submit" onclick="return confirm('Tem certeza que deseja excluir?');" style="background-color: transparent;border: none;"><i class="far fa-trash-alt" color="#007bff"></i></button>  
              </form>  
            </td>
            @else
            <td style="display: none;"></td>
            @endif
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>