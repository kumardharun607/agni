<div class="flex gap-2 justify-end items-center">
  @userCan('Roles','edit')
    <a href="{{ route('roles.edit', $row->id) }}" title="Edit" class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-yellow-500 hover:bg-yellow-600 text-white shadow-sm">
      <i class="fa fa-edit"></i>
    </a>
  @enduserCan
  @userCan('Roles','delete')
    <button type="button" title="Delete" class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-red-600 hover:bg-red-700 text-white shadow-sm"
            onclick="confirmDelete('{{ route('roles.destroy', $row->id) }}', '#dt')">
      <i class="fa fa-trash"></i>
    </button>
  @enduserCan
</div>
