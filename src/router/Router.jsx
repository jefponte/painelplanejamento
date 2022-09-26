import { BrowserRouter, Routes, Route } from "react-router-dom";
import PageGoalSelected from "../pages/PageGoalSelected";
import ErrorPage from "../pages/ErrorPage";
import PagePanel from "../pages/PagePanel";

function Router() {
    return (<BrowserRouter>
        <Routes>
            <Route path="/" element={<PagePanel />} />
            <Route path="/meta/:id" element={<PageGoalSelected />} />
            <Route path="*" element={<ErrorPage />} />
        </Routes>
    </BrowserRouter>);
}

export default Router;