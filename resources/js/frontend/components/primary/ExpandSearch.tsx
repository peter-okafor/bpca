import { FC, HtmlHTMLAttributes } from "react";
import { useState, useEffect } from "react";
import { ShowMapButton } from "@frontend/components";
// import { Button } from '@/Components/Button';
import { Button } from "./Button";
import { Inertia } from "@inertiajs/inertia";

export const ExpandSearch: FC<HtmlHTMLAttributes<HTMLElement>> = (props) => {
    const [route, setRoute] = useState({
        path: "",
        count: 0,
    });

    const handleExpandSearch = () => {
        // Get the current URL
        const currentUrl = window.location.href;

        // Create a URL object to extract the query parameters
        const url = new URL(currentUrl);

        // Get the pest and postcode query parameters
        const pest = url.searchParams.get("pest");
        const postcode = url.searchParams.get("postcode");

        Inertia.visit(`/expand-search`, {
            data: {
                path: route?.path,
                pest: pest,
                postcode: postcode,
            },
        });
    };

    // Get route path
    useEffect(() => {
        const path = window?.location?.pathname;
        setRoute({
            ...route,
            path: path,
            count: path.split("/").length,
        });
    }, []);

    return (
        <>
            <div {...props}>
                <h3 className="justify-self-start self-center">
                    No provider found for this postcode, search for another
                    postcode or click to{" "}
                    <span className="font-semibold">expand</span> your search.
                </h3>
                <div className="justify-self-end self-center">
                    {/* <ShowMapButton
                        label={"Expand Search"}
                    /> */}
                    <Button
                        backgroundColor="bg-pest-cyprus"
                        textColor="text-white"
                        onClick={handleExpandSearch}
                        label={"Expand Search"}
                        className={"font-semibold px-8"}
                    />
                </div>
            </div>
        </>
    );
};
