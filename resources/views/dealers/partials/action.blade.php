<div class="flex gap-2 justify-end items-center">
  @userCan("Dealer","view")
    <a href="{{ route('dealers.show', $row->id) }}" title="View" class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-gray-700 hover:bg-gray-800 text-white shadow-sm">
      <i class="fa fa-eye"></i>
    </a>
  @enduserCan
  @userCan('Dealer','edit')
    <a href="{{ route('dealers.edit', $row->id) }}" title="Edit" class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-yellow-500 hover:bg-yellow-600 text-white shadow-sm">
      <i class="fa fa-edit"></i>
    </a>
  @enduserCan
  @userCan('Dealer','delete')
    <button type="button" title="Delete" class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-red-600 hover:bg-red-700 text-white shadow-sm"
            onclick="confirmDelete('{{ route('dealers.destroy', $row->id) }}', '#dt')">
      <i class="fa fa-trash"></i>
    </button>
  @enduserCan
</div>
