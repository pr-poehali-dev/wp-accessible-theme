import Layout from "@/components/Layout";
import Icon from "@/components/ui/icon";

const PROJECTS = [
  {
    title: "Доступная среда",
    date: "2023–2024",
    status: "Активный",
    description: "Обследование объектов социальной инфраструктуры на предмет доступности для маломобильных граждан. Разработка рекомендаций по адаптации зданий и территорий.",
    icon: "Building2",
    tags: ["Доступность", "Инфраструктура"],
  },
  {
    title: "Спорт без границ",
    date: "2022–2024",
    status: "Активный",
    description: "Организация адаптивных спортивных секций для людей с различными видами инвалидности. Участие в региональных и федеральных паралимпийских соревнованиях.",
    icon: "Trophy",
    tags: ["Спорт", "Реабилитация"],
  },
  {
    title: "Цифровая грамотность",
    date: "2024",
    status: "Новый",
    description: "Бесплатные курсы компьютерной грамотности для людей с инвалидностью. Обучение работе с государственными порталами и дистанционными сервисами.",
    icon: "Monitor",
    tags: ["Образование", "Технологии"],
  },
  {
    title: "Мастерская талантов",
    date: "2021–2024",
    status: "Активный",
    description: "Творческая мастерская для людей с ограниченными возможностями. Обучение прикладному искусству, организация выставок и ярмарок изделий ручной работы.",
    icon: "Palette",
    tags: ["Творчество", "Культура"],
  },
  {
    title: "Правовая помощь",
    date: "2020–2024",
    status: "Активный",
    description: "Бесплатные юридические консультации для инвалидов по вопросам получения льгот, защиты прав, оформления документов и обжалования решений органов власти.",
    icon: "Scale",
    tags: ["Право", "Консультации"],
  },
  {
    title: "Путь к работе",
    date: "2023",
    status: "Завершён",
    description: "Программа трудоустройства инвалидов: профориентация, обучение, содействие в поиске работодателей, готовых принять людей с ограниченными возможностями.",
    icon: "Briefcase",
    tags: ["Занятость", "Профориентация"],
  },
];

const STATUS_COLORS: Record<string, { bg: string; text: string }> = {
  "Активный":  { bg: "#D1FAE5", text: "#065F46" },
  "Новый":     { bg: "#DBEAFE", text: "#1E40AF" },
  "Завершён":  { bg: "#F3F4F6", text: "#6B7280" },
};

export default function ProjectsPage() {
  return (
    <Layout>
      <div className="animate-fade-in">
        <div
          className="rounded-2xl p-8 sm:p-10 mb-8 text-white"
          style={{ background: "linear-gradient(135deg, #1E2A3E 0%, #2C3E50 100%)" }}
        >
          <div className="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 text-sm mb-4">
            <Icon name="Rocket" size={14} />
            Наша деятельность
          </div>
          <h1 className="text-3xl sm:text-4xl font-extrabold mb-2" style={{ fontFamily: "Montserrat, sans-serif" }}>
            ПРОЕКТЫ
          </h1>
          <p className="text-blue-100">Социальные проекты и программы организации</p>
        </div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
          {PROJECTS.map((project, i) => {
            const sc = STATUS_COLORS[project.status] ?? { bg: "#F3F4F6", text: "#6B7280" };
            return (
              <div key={project.title} className={`voi-card p-5 flex flex-col stagger-${(i % 6) + 1} animate-fade-in`}>
                <div className="flex items-start justify-between mb-4">
                  <div
                    className="w-11 h-11 rounded-xl flex items-center justify-center"
                    style={{ background: "var(--brand-light)" }}
                  >
                    <Icon name={project.icon as "Trophy"} size={20} style={{ color: "var(--brand-dark)" }} />
                  </div>
                  <span
                    className="text-xs font-semibold px-2.5 py-1 rounded-full"
                    style={{ background: sc.bg, color: sc.text }}
                  >
                    {project.status}
                  </span>
                </div>
                <h3 className="font-bold text-base mb-1" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                  {project.title}
                </h3>
                <div className="flex items-center gap-1 text-xs text-gray-400 mb-3">
                  <Icon name="Calendar" size={12} />
                  {project.date}
                </div>
                <p className="text-gray-600 text-sm leading-relaxed flex-1">{project.description}</p>
                <div className="flex gap-2 mt-4 flex-wrap">
                  {project.tags.map((tag) => (
                    <span key={tag} className="text-xs px-2 py-0.5 rounded bg-gray-100 text-gray-500">
                      {tag}
                    </span>
                  ))}
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </Layout>
  );
}
