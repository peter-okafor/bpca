import { Inertia } from "@inertiajs/inertia";
import { AnchorHTMLAttributes, FC } from "react";

export const BackToSearch: FC<AnchorHTMLAttributes<HTMLAnchorElement>> = ({
    children,
    className,
    ...props
}) => (
    <a className={`text-xs text-white cursor-pointer ${className}`} onClick={() => Inertia.visit("/pests")} {...props}> 
        &#60; &nbsp; Back to search
    </a>
)