import Alpine from 'alpinejs';
import './bootstrap';

window.Alpine = Alpine;
Alpine.start();

// استماع لبيانات المستخدم من الهيدر
const userRoleMeta = document.querySelector('meta[name="user-role"]');
const userIdMeta = document.querySelector('meta[name="user-id"]');

// التحقق من وجود Echo
if (window.Echo) {
    // الاستماع لإشعارات الإدمن (فقط لو كان المستخدم أدمن)
    if (userRoleMeta && userRoleMeta.content === 'admin') {
        window.Echo.private('admin-notifications')
            .listen('TicketCreated', (e) => {
                window.dispatchEvent(new CustomEvent('admin-notification', {
                    detail: {
                        title: 'تذكرة جديدة',
                        message: e.subject,
                        time: new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' }),
                        link: '/tickets'
                    }
                }));
            })
            .listen('LeaveRequestCreated', (e) => {
                window.dispatchEvent(new CustomEvent('admin-notification', {
                    detail: {
                        title: 'طلب إجازة جديد',
                        message: e.subject,
                        time: new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' }),
                        link: '/leave-requests'
                    }
                }));
            });
    }

    // استماع الموظف لتحديثات تذكرته وإجازته
    if (userIdMeta && userIdMeta.content) {
        window.Echo.private('App.Models.User.' + userIdMeta.content)
            .listen('TicketUpdated', (e) => {
                window.dispatchEvent(new CustomEvent('admin-notification', {
                    detail: {
                        title: 'تحديث في التذكرة',
                        message: e.message,
                        time: new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' }),
                        link: '/tickets'
                    }
                }));
            })
            .listen('LeaveRequestUpdated', (e) => {
                window.dispatchEvent(new CustomEvent('admin-notification', {
                    detail: {
                        title: 'تحديث في طلب الإجازة',
                        message: e.message,
                        time: new Date().toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit' }),
                        link: '/leave-requests'
                    }
                }));
            });
    }
}
