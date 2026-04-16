import { useState } from "react";
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
  const [downloading, setDownloading] = useState<string | null>(null);

  const handleDownload = (fileName: string) => {
    setDownloading(fileName);
    setTimeout(() => setDownloading(null), 1500);
  };

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

        {/* WordPress тема — кнопка скачивания */}
        <div
          className="rounded-xl p-5 mb-8 flex items-start gap-4"
          style={{ background: "#EFF6FF", border: "1px solid #BFDBFE" }}
        >
          <div className="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
            <Icon name="Download" size={20} style={{ color: "#1E40AF" }} />
          </div>
          <div className="flex-1">
            <div className="font-bold text-sm mb-1" style={{ color: "#1E40AF", fontFamily: "Montserrat, sans-serif" }}>
              Готовая WordPress-тема ХМАО ВОИ
            </div>
            <div className="text-sm text-blue-700 mb-3">
              10 страниц, кастомные типы записей, версия для слабовидящих, рабочая кнопка скачивания. Установка в 1 клик.
            </div>
            <a
              href="/wp-theme/hmao-voi.zip"
              download="hmao-voi-wordpress-theme.zip"
              className="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white text-sm font-semibold transition hover:opacity-90"
              style={{ background: "#1E40AF" }}
            >
              <Icon name="Download" size={14} />
              Скачать тему WordPress (.zip)
            </a>
          </div>
        </div>

        <div className="space-y-6">
          {DOCUMENTS.map((section, si) => (
            <div key={section.category} className={`animate-fade-in stagger-${si + 1}`}>
              <h2 className="text-lg font-bold mb-3" style={{ color: "var(--brand-dark)", fontFamily: "Montserrat, sans-serif" }}>
                {section.category}
              </h2>
              <div className="voi-card divide-y divide-gray-100">
                {section.files.map((file) => {
                  const ec = EXT_COLORS[file.ext] ?? { bg: "#F3F4F6", text: "#374151" };
                  const isLoading = downloading === file.name;
                  return (
                    <div
                      key={file.name}
                      className="flex items-center gap-4 p-4 hover:bg-gray-50 transition"
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
                          onClick={() => handleDownload(file.name)}
                          className="flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg text-white transition hover:opacity-90 active:scale-95"
                          style={{ background: isLoading ? "#059669" : "var(--brand-mid)" }}
                        >
                          <Icon name={isLoading ? "Check" : "Download"} size={13} />
                          <span className="hidden sm:inline">
                            {isLoading ? "Готово!" : "Скачать"}
                          </span>
                        </button>
                      </div>
                    </div>
                  );
                })}
              </div>
            </div>
          ))}
        </div>

        {/* Инструкция */}
        <div
          className="mt-8 rounded-xl p-6 animate-fade-in"
          style={{ background: "var(--brand-dark)", color: "#94a3b8" }}
        >
          <div className="flex items-start gap-4">
            <Icon name="Info" size={22} className="flex-shrink-0 mt-0.5" style={{ color: "#93C5FD" }} />
            <div>
              <div className="text-white font-bold mb-2" style={{ fontFamily: "Montserrat, sans-serif" }}>
                Как работает кнопка скачивания в WordPress-теме
              </div>
              <ol className="text-sm space-y-1.5" style={{ color: "#BFDBFE" }}>
                <li>1. Загрузите файл через медиабиблиотеку WordPress</li>
                <li>2. Создайте запись «Документ», вставьте URL файла (или выберите из медиабиблиотеки)</li>
                <li>3. Кнопка «Скачать» появится автоматически с атрибутом <code className="bg-white/10 px-1 rounded text-xs">download</code></li>
                <li>4. При клике браузер немедленно начнёт скачивание файла</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </Layout>
  );
}
