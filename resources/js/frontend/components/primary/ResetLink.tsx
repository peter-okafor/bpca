import { AnchorHTMLAttributes, FC } from "react";

export const ResetLink: FC<AnchorHTMLAttributes<HTMLAnchorElement>> = ({
    children,
    className,
    ...props
}) => (
    <a className={`text-sm text-white cursor-pointer ${className}`} {...props}> Reset filters </a>
)