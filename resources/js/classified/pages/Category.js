import {useEffect, useState} from "react";
import {useParams} from "react-router-dom";
import httpClient from "@classified/core/axios";
import Spinner from "../components/Spinner";
import useTranslation from "../hooks/useTranslation";
import app from "../config/app";

const Category = () => {
    const params = useParams();
    const [loading, setLoading] = useState(true);
    const [category, setCategory] = useState({});
    const [posts, setPosts] = useState([]);

    useEffect(() => {
        setLoading(true);
        httpClient
            .get(`category-post/${params.category}`)
            .then(response => {
                setLoading(false);
                if (response.data.success && response.data.data.length > 0) {
                    setPosts(useTranslation({data: response.data.data, lang: app.locale}));
                    setCategory(useTranslation({data: response.data.data[0].category, lang: app.locale}));
                }
            })
            .catch(() => setLoading(false));
    }, [params.category]);

    return (
        <>
            <Spinner spinner={loading} />
            <div className="text-center mb-4">
                <div className="card-box-title">{category.name}</div>
            </div>
            <div className="row mb-5">
                {posts &&
                    posts.map((item, index) => (
                        <div key={item.id} className="col-6 col-md-3 mb-4">
                            <div className="card-box-body text-start mt-2" dangerouslySetInnerHTML={{__html: item.content}} />
                        </div>
                    ))}
            </div>
        </>
    );
};

export default Category;
