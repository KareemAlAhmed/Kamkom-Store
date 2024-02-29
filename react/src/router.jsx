import {createBrowserRouter} from "react-router-dom"
import Login from "./views/Login";
import NotFound from "./views/NotFound";

const router =createBrowserRouter([
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