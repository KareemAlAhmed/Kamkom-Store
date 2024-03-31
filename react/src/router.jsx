import {createBrowserRouter} from "react-router-dom"
import Login from "./views/Login";
import NotFound from "./views/NotFound";
import HomePage from "./views/HomePage";

const router =createBrowserRouter([
    {
        path:"/",
        element:<HomePage />
    },
    {
        path:"/login",
        element:<Login />
    },
    {
        path:"*",
        element:<NotFound />
    }
])

export default router;