<!-- Hiển thị một hàng trong bảng danh mục -->
<tr>
    <td class="text-center">{{ $index }}</td>
    <td style="padding-left": {{ $level * 20 }}px>{{ $category->name }}</td>
    <td class="text-center">{{ category->type }}</td>
    <td class="text-center">
        <!-- Nút chỉnh sửa -->
        <a href="{{ route('category.edit', $category->id ) }}" class="btn btn-success btn-sm">
            <i class="fa fa-edit"></i>
        </a>
        <!-- Form xóa danh mục -->
        <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc xóa danh mục này?')">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    </td>
</tr>

<!-- Lặp qua các danh mục con để hiển thị đệ quy -->
@foreach($category->allChildren as $childIndex => $child)
    @include('backend.category.category_row', [
        'category' => $child,
        'index' => $index . '.' . ($childIndex + 1), // số thứ tự (1.1, 1.2,.....)
        'level' => $level + 1, // Tăng cấp độ để thụt lùi
    ])
@endforeach