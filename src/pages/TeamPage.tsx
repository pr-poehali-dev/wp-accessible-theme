import Layout from "@/components/Layout";
import Icon from "@/components/ui/icon";

const TEAM = [
  {
    name: "Фамилия Имя Отчество",
    position: "Председатель ХМАО ВОИ",
    emoji: "👤",
    phone: "8 (3467) 00-00-01",
    email: "chairman@hmao-voi.ru",
  },
  {
    name: "Фамилия Имя Отчество",
    position: "Заместитель председателя",
    emoji: "👤",
    phone: "8 (3467) 00-00-02",
    email: "",
  },
  {
    name: "Фамилия Имя Отчество",
    position: "Ответственный секретарь",
    emoji: "👤",
    phone: "8 (3467) 00-00-03",
    email: "",
  },
  {
    name: "Фамилия Имя Отчество",
    position: "Юрисконсульт",
    emoji: "👤",
    phone: "",
    email: "",
  },
  {
    name: "Фамилия Имя Отчество",
    position: "Специалист по социальной работе",
    emoji: "👤",
    phone: "",
    email: "",
  },
  {
    name: "Фамилия Имя Отчество",
    position: "Специалист по проектной деятельности",
    emoji: "👤",
    phone: "",
    email: "",
  },
];

export default function TeamPage() {
  return (
    <Layout>
      <div className="animate-fade-in">
        <div
          className="rounded-2xl p-8 sm:p-10 mb-8 text-white"
          style={{ background: "linear-gradient(135deg, #1E2A3E 0%, #2C3E50 100%)" }}
        >
          <div className="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 text-sm mb-4">
            <Icon name="Users" size={14} />
            Наша команда
          </div>
          <h1 className="text-3xl sm:text-4xl font-extrabold mb-2" style={{ fontFamily: "Montserrat, sans-serif" }}>
            КОМАНДА
          </h1>
          <p className="text-blue-100">Сотрудники и руководство организации</p>
        </div>

        {/* Пояснение для демо */}
        <div
          className="rounded-xl p-4 mb-6 flex items-start gap-3"
          style={{ background: "#F0FDF4", border: "1px solid #BBF7D0" }}
        >
          <Icon name="Info" size={16} className="flex-shrink-0 mt-0.5" style={{ color: "#15803D" }} />
          <div className="text-sm" style={{ color: "#166534" }}>
            <strong>В WordPress-теме:</strong> сотрудники управляются через тип записей «Сотрудники» в панели администратора.
            Добавьте фото, имя, должность, телефон, email — карточки появятся автоматически.
          </div>
        </div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
          {TEAM.map((member, i) => (
            <div key={i} className={`voi-card overflow-hidden stagger-${(i % 6) + 1} animate-fade-in`}>
              {/* Фото */}
              <div
                className="w-full h-44 flex items-center justify-center text-6xl"
                style={{ background: "var(--brand-light)" }}
              >
                {member.emoji}
              </div>
              {/* Инфо */}
              <div className="p-5">
                <div className="font-bold text-base mb-1" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                  {member.name}
                </div>
                <div className="text-sm text-gray-500 mb-3">{member.position}</div>
                {(member.phone || member.email) && (
                  <div className="space-y-1.5 text-sm text-gray-500">
                    {member.phone && (
                      <div className="flex items-center gap-2">
                        <Icon name="Phone" size={13} style={{ color: "#3B82F6" }} />
                        {member.phone}
                      </div>
                    )}
                    {member.email && (
                      <div className="flex items-center gap-2">
                        <Icon name="Mail" size={13} style={{ color: "#3B82F6" }} />
                        <a href={`mailto:${member.email}`} style={{ color: "#3B82F6" }}>{member.email}</a>
                      </div>
                    )}
                  </div>
                )}
              </div>
            </div>
          ))}
        </div>
      </div>
    </Layout>
  );
}
