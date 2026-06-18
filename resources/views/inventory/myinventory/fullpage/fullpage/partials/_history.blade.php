<div id="tab-history" class="tab-content hidden flex-col gap-6">
    <div class="card !mb-0 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="form-group">
                <label>Created Date</label>
                <span class="sub-label">Date and time of creation</span>
                <input type="text" value="{{ date('d M Y, h:i A') }}" readonly
                    class="form-control px-3 bg-slate-50/50 text-slate-500">
            </div>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h2 class="card-title !mb-0">History</h2>
            <div class="relative w-64 custom-select-wrapper">
                <button type="button" class="form-control flex items-center pl-3 pr-8 text-left bg-slate-50">
                    <span class="truncate text-slate-800 selected-text">All Activities</span>
                </button>
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <div class="custom-dropdown-panel">
                    <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">All Activities</div>
                    <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Status Changes</div>
                    <div class="p-2 hover:bg-slate-50 cursor-pointer text-[13px] px-3 dd-item">Price Updates</div>
                </div>
            </div>
        </div>

        <div class="border border-slate-200 rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 border-b border-slate-200 text-[11px] text-slate-600 font-semibold uppercase tracking-wider">
                        <th class="p-4">Date & Time</th>
                        <th class="p-4">User</th>
                        <th class="p-4">Action</th>
                        <th class="p-4">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($auditLogs ?? [] as $log)
                        <tr class="border-b border-slate-100">
                            <td class="p-4 text-[13px] text-slate-800">
                                {{ \Carbon\Carbon::parse($log->insertdatetime)->format('d M Y, h:i A') }}</td>
                            <td class="p-4 text-[13px] text-slate-800 font-medium">{{ $log->user_name ?? 'System' }}</td>
                            <td class="p-4">
                                <span
                                    class="px-2.5 py-1 rounded-md text-[12px] font-semibold {{ $log->action === 'Created' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="p-4 text-[13px] text-slate-600">Product ID: {{ $log->entity_id }} (New values:
                                {{ $log->new_values }})</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-slate-400">No activity history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>