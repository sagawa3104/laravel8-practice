import { BrowserRouter, Route, Routes } from "react-router-dom";
import ReactDOM from 'react-dom';
import SearchInspection from "./SearchInspection/SearchInspection";
import InspectProduct from "./InspectProduct/InspectProduct";

function AppRoutes() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/react" element={<SearchInspection />} />
                <Route path="/react/inspect" element={<InspectProduct />} />
                <Route path="/react/contact" element={<Contact />} />
            </Routes>
        </BrowserRouter>
    );
}

function Home() {
return <h2>Home</h2>;
}

function About() {
return <h2>About</h2>;
}

function Contact() {
return <h2>Contact</h2>;
}

if (document.getElementById('app')) {
    ReactDOM.render(<AppRoutes />, document.getElementById('app'));
}
