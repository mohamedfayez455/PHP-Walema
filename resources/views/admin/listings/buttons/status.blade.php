<span id="{{ 'status-' . $id }}" class="badge status {{ $status == 'pending' ? 'alert-warning' : ($status == 'active' ? 'alert-success' : 'alert-danger') }}">{{ ucfirst($status) }}</span>