import Layout from "@/components/Layout";
import Icon from "@/components/ui/icon";

const DEPARTMENTS = [
  {
    city: "Ханты-Мансийск",
    head: "Иванова Мария Ивановна",
    phone: "8 (3467) 30-00-01",
    members: 420,
  },
  {
    city: "Сургут",
    head: "Петров Александр Николаевич",
    phone: "8 (3462) 30-00-02",
    members: 980,
  },
  {
    city: "Нижневартовск",
    head: "Сидорова Елена Фёдоровна",
    phone: "8 (3466) 30-00-03",
    members: 760,
  },
  {
    city: "Нефтеюганск",
    head: "Кузнецов Виктор Павлович",
    phone: "8 (3463) 30-00-04",
    members: 510,
  },
  {
    city: "Когалым",
    head: "Смирнова Ольга Викторовна",
    phone: "8 (34667) 30-00-05",
    members: 310,
  },
  {
    city: "Лангепас",
    head: "Фёдоров Игорь Семёнович",
    phone: "8 (34669) 30-00-06",
    members: 280,
  },
];

export default function StructurePage() {
  return (
    <Layout>
      <div className="animate-fade-in">
        <div
          className="rounded-2xl p-8 sm:p-10 mb-8 text-white"
          style={{ background: "linear-gradient(135deg, #1E2A3E 0%, #2C3E50 100%)" }}
        >
          <div className="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 text-sm mb-4">
            <Icon name="Sitemap" size={14} />
            Организационная структура
          </div>
          <h1 className="text-3xl sm:text-4xl font-extrabold mb-2" style={{ fontFamily: "Montserrat, sans-serif" }}>
            СТРУКТУРА ХМАО ВОИ
          </h1>
          <p className="text-blue-100">Региональная организация и местные отделения</p>
        </div>

        {/* Руководство */}
        <div className="voi-card p-6 mb-6 animate-fade-in stagger-1">
          <span className="section-line"></span>
          <h2 className="text-xl font-bold mb-4" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
            Руководство региональной организации
          </h2>
          <div className="grid sm:grid-cols-3 gap-4">
            {[
              { role: "Председатель", name: "Фамилия Имя Отчество", icon: "User" },
              { role: "Заместитель председателя", name: "Фамилия Имя Отчество", icon: "User" },
              { role: "Ответственный секретарь", name: "Фамилия Имя Отчество", icon: "User" },
            ].map((person) => (
              <div
                key={person.role}
                className="flex items-center gap-3 p-4 rounded-xl"
                style={{ background: "var(--brand-light)" }}
              >
                <div
                  className="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                  style={{ background: "var(--brand-mid)" }}
                >
                  <Icon name="User" size={18} className="text-white" />
                </div>
                <div>
                  <div className="text-xs text-gray-500 mb-0.5">{person.role}</div>
                  <div className="font-semibold text-sm" style={{ color: "var(--brand-dark)" }}>
                    {person.name}
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Местные отделения */}
        <div className="animate-fade-in stagger-2">
          <h2 className="text-xl font-bold mb-4" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
            Местные отделения
          </h2>
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {DEPARTMENTS.map((dep, i) => (
              <div key={dep.city} className={`voi-card p-5 stagger-${(i % 6) + 1} animate-fade-in`}>
                <div className="flex items-center justify-between mb-3">
                  <h3 className="font-bold" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                    {dep.city}
                  </h3>
                  <span
                    className="text-xs font-bold px-2 py-1 rounded-full text-white"
                    style={{ background: "var(--brand-mid)" }}
                  >
                    {dep.members} чел.
                  </span>
                </div>
                <div className="space-y-1.5 text-sm text-gray-600">
                  <div className="flex items-center gap-2">
                    <Icon name="User" size={13} style={{ color: "#3B82F6" }} />
                    {dep.head}
                  </div>
                  <div className="flex items-center gap-2">
                    <Icon name="Phone" size={13} style={{ color: "#3B82F6" }} />
                    {dep.phone}
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Схема */}
        <div className="voi-card p-6 mt-6 animate-fade-in stagger-3">
          <span className="section-line"></span>
          <h2 className="text-xl font-bold mb-3" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
            Органы управления
          </h2>
          <div className="space-y-3 text-gray-600">
            <div className="flex items-start gap-3 p-3 rounded-lg bg-gray-50">
              <Icon name="Star" size={16} className="mt-0.5 flex-shrink-0" style={{ color: "#3B82F6" }} />
              <div>
                <div className="font-semibold text-sm mb-0.5" style={{ color: "var(--brand-dark)" }}>Конференция</div>
                <div className="text-sm">Высший руководящий орган организации. Собирается не реже одного раза в 5 лет.</div>
              </div>
            </div>
            <div className="flex items-start gap-3 p-3 rounded-lg bg-gray-50">
              <Icon name="Shield" size={16} className="mt-0.5 flex-shrink-0" style={{ color: "#3B82F6" }} />
              <div>
                <div className="font-semibold text-sm mb-0.5" style={{ color: "var(--brand-dark)" }}>Правление</div>
                <div className="text-sm">Руководящий орган в период между конференциями. Избирается на 5 лет.</div>
              </div>
            </div>
            <div className="flex items-start gap-3 p-3 rounded-lg bg-gray-50">
              <Icon name="Eye" size={16} className="mt-0.5 flex-shrink-0" style={{ color: "#3B82F6" }} />
              <div>
                <div className="font-semibold text-sm mb-0.5" style={{ color: "var(--brand-dark)" }}>Ревизионная комиссия</div>
                <div className="text-sm">Контрольный орган организации. Проводит ревизии финансово-хозяйственной деятельности.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Layout>
  );
}
