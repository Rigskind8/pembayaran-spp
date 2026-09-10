<div class="notif-wrapper" style="position: relative; display: inline-block;">
    <button type="button" id="notifBellBtn" onclick="toggleNotifDropdown()" style="position: relative; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #475569; transition: all .15s;">
        <i class="fas fa-bell" style="font-size: 16px;"></i>
        @if(isset($globalUnreadCount) && $globalUnreadCount > 0)
            <span id="notifBadge" style="position: absolute; top: -4px; right: -4px; background: #ef4444; color: white; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 99px; line-height: 1; border: 2px solid #ffffff;">
                {{ $globalUnreadCount > 9 ? '9+' : $globalUnreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown Menu -->
    <div id="notifDropdown" style="display: none; position: absolute; right: 0; top: 48px; width: 320px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); z-index: 1000; overflow: hidden; animation: notifIn .2s ease;">
        <div style="padding: 14px 16px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; background: #f8fafc;">
            <span style="font-size: 13px; font-weight: 800; color: #0f172a;">🔔 Notifikasi</span>
            <button type="button" onclick="markAllNotificationsRead()" style="background: none; border: none; font-size: 11px; font-weight: 700; color: #2563eb; cursor: pointer;">Tandai Dibaca</button>
        </div>

        <div style="max-height: 320px; overflow-y: auto;">
            @forelse($globalNotifications ?? [] as $notif)
                <div style="padding: 12px 16px; border-bottom: 1px solid #f1f5f9; transition: background .12s; {{ !($notif->dibaca ?? false) ? 'background: #eff6ff;' : '' }}">
                    <div style="font-size: 12.5px; font-weight: 700; color: #1e293b; margin-bottom: 2px;">
                        {{ $notif->judul ?? 'Notifikasi' }}
                    </div>
                    <div style="font-size: 11.5px; color: #64748b; line-height: 1.4;">
                        {{ $notif->pesan ?? '' }}
                    </div>
                    <div style="font-size: 10px; color: #94a3b8; margin-top: 4px; font-weight: 600;">
                        {{ isset($notif->created_at) ? \Carbon\Carbon::parse($notif->created_at)->diffForHumans() : '' }}
                    </div>
                </div>
            @empty
                <div style="padding: 24px; text-align: center; color: #94a3b8; font-size: 12px;">
                    <i class="fas fa-bell-slash" style="font-size: 20px; display: block; margin-bottom: 6px;"></i>
                    Belum ada notifikasi baru.
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
@keyframes notifIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script>
function toggleNotifDropdown() {
    const dd = document.getElementById('notifDropdown');
    if (!dd) return;
    dd.style.display = dd.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    const btn = document.getElementById('notifBellBtn');
    const dd = document.getElementById('notifDropdown');
    if (dd && btn && !btn.contains(e.target) && !dd.contains(e.target)) {
        dd.style.display = 'none';
    }
});

function markAllNotificationsRead() {
    fetch("{{ route('notifications.markRead') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({})
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const badge = document.getElementById('notifBadge');
            if (badge) badge.remove();
            document.querySelectorAll('#notifDropdown > div > div').forEach(el => {
                el.style.background = '#ffffff';
            });
        }
    });
}
</script>

