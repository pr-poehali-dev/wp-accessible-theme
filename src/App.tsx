
import { Toaster } from "@/components/ui/toaster";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Index from "./pages/Index";
import NotFound from "./pages/NotFound";
import StructurePage from "./pages/StructurePage";
import ConventionPage from "./pages/ConventionPage";
import GreatPeoplePage from "./pages/GreatPeoplePage";
import ProjectsPage from "./pages/ProjectsPage";
import NewsPage from "./pages/NewsPage";
import EventsPage from "./pages/EventsPage";
import PhotosPage from "./pages/PhotosPage";
import DocumentsPage from "./pages/DocumentsPage";
import TeamPage from "./pages/TeamPage";

const queryClient = new QueryClient();

const App = () => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Index />} />
          <Route path="/structure" element={<StructurePage />} />
          <Route path="/convention" element={<ConventionPage />} />
          <Route path="/great-people" element={<GreatPeoplePage />} />
          <Route path="/projects" element={<ProjectsPage />} />
          <Route path="/news" element={<NewsPage />} />
          <Route path="/events" element={<EventsPage />} />
          <Route path="/photos" element={<PhotosPage />} />
          <Route path="/documents" element={<DocumentsPage />} />
          <Route path="/team" element={<TeamPage />} />
          {/* ADD ALL CUSTOM ROUTES ABOVE THE CATCH-ALL "*" ROUTE */}
          <Route path="*" element={<NotFound />} />
        </Routes>
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

export default App;