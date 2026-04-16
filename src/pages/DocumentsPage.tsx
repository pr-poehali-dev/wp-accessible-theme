import Layout from "@/components/Layout";
import Icon from "@/components/ui/icon";

const DOCUMENTS = [
  {
    category: "Учредительные документы",
    files: [
      { name: "Устав ХМАО ВОИ (редакция 2022)", ext: "PDF", size: "2.1 МБ", date: "15.03.2022" },
      { name: "Свидетельство о государственной регистрации", ext: "PDF", size: "0.5 МБ", date: "01.06.1997" },
    ],
  },
  {
    category: "Отчёты и планы",
    files: [
      { name: "Годовой отчёт о деятельности за 2025 год", ext: "PDF", size: "3.8 МБ", date: "31.01.2026" },
      { name: "Финансовый отчёт за 2025 год", ext: "PDF", size: "1.2 МБ", date: "31.01.2026" },
      { name: "План работы на 2026 год", ext: "DOCX", size: "0.8 МБ", date: "10.01.2026" },
    ],
  },
  {
    category: "Нормативные документы",
    files: [
      { name: "Федеральный закон «О социальной защите инвалидов в РФ»", ext: "PDF", size: "1.5 МБ", date: "24.11.1995" },
      { name: "Конвенция ООН о правах инвалидов (русский текст)", ext: "PDF", size: "1.1 МБ", date: "13.12.2006" },
      { name: "Региональная программа «Доступная среда» 2024–2026", ext: "PDF", size: "2.4 МБ", date: "01.01.2024" },
    ],
  },
  {
    category: "Методические материалы",
    files: [
      { name: "Памятка по получению технических средств реабилитации", ext: "PDF", size: "0.6 МБ", date: "01.03.2025" },
      { name: "Как оформить инвалидность: пошаговая инструкция", ext: "PDF", size: "0.9 МБ", date: "15.02.2025" },
      { name: "Льготы и выплаты инвалидам в 2026 году", ext: "DOCX", size: "0.7 МБ", date: "05.01.2026" },
    ],
  },
];

const EXT_COLORS: Record<string, { bg: string; text: string }> = {
  PDF:  { bg: "#FEE2E2", text: "#991B1B" },
  DOCX: { bg: "#DBEAFE", text: "#1E40AF" },
  XLSX: { bg: "#D1FAE5", text: "#065F46" },
};

export default function DocumentsPage() {
  return (
    <Layout>
      <div className="animate-fade-in">
        <div
          className="rounded-2xl p-8 sm:p-10 mb-8 text-white"
          style={{ background: "linear-gradient(135deg, #1E2A3E 0%, #2C3E50 100%)" }}
        >
          <div className="inline-flex items-center gap-2 bg-white/10 rounded-full px-4 py-1.5 text-sm mb-4">
            <Icon name="FolderOpen" size={14} />
            Документы организации
          </div>
          <h1 className="text-3xl sm:text-4xl font-extrabold mb-2" style={{ fontFamily: "Montserrat, sans-serif" }}>
            ДОКУМЕНТЫ
          </h1>
          <p className="text-blue-100">Документы для скачивания</p>
        </div>

        <div className="space-y-6">
          {DOCUMENTS.map((section, si) => (
            <div key={section.category} className={`animate-fade-in stagger-${si + 1}`}>
              <h2 className="text-lg font-bold mb-3" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                {section.category}
              </h2>
              <div className="voi-card divide-y divide-gray-100">
                {section.files.map((file, fi) => {
                  const ec = EXT_COLORS[file.ext] ?? { bg: "#F3F4F6", text: "#374151" };
                  return (
                    <div
                      key={file.name}
                      className={`flex items-center gap-4 p-4 hover:bg-gray-50 transition stagger-${fi + 1} animate-fade-in`}
                    >
                      <div
                        className="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                        style={{ background: "var(--brand-light)" }}
                      >
                        <Icon name="FileText" size={18} style={{ color: "var(--brand-dark)" }} />
                      </div>
                      <div className="flex-1 min-w-0">
                        <div className="font-medium text-sm truncate" style={{ color: "var(--brand-dark)" }}>
                          {file.name}
                        </div>
                        <div className="flex items-center gap-3 text-xs text-gray-400 mt-0.5">
                          <span className="flex items-center gap-1">
                            <Icon name="HardDrive" size={11} />
                            {file.size}
                          </span>
                          <span className="flex items-center gap-1">
                            <Icon name="Calendar" size={11} />
                            {file.date}
                          </span>
                        </div>
                      </div>
                      <div className="flex items-center gap-3 flex-shrink-0">
                        <span
                          className="text-xs font-bold px-2 py-0.5 rounded"
                          style={{ background: ec.bg, color: ec.text }}
                        >
                          {file.ext}
                        </span>
                        <button
                          className="flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded-lg text-white transition hover:opacity-90"
                          style={{ background: "var(--brand-mid)" }}
                        >
                          <Icon name="Download" size={13} />
                          <span className="hidden sm:inline">Скачать</span>
                        </button>
                      </div>
                    </div>
                  );
                })}
              </div>
            </div>
          ))}
        </div>
      </div>
    </Layout>
  );
}
