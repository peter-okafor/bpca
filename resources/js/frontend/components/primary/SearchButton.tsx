import { ButtonHTMLAttributes, FC } from "react";

export const SearchButton: FC<ButtonHTMLAttributes<HTMLButtonElement>> = ({
    className,
    ...props
}) => (
    <button className={`text-base text-white font-bold bg-[#2F1C39] ${className}`} {...props}>
        Search
    </button>
)