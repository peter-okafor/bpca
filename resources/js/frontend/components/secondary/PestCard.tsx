import { PestInterface } from "@/frontend/data/ProviderInterface";
import { FC } from "react";
import { PestSVG } from "..";
import { Image, ImageProps } from "../primary/Image";

interface PestCardProps {
    pest: PestInterface;
    className?: string;
    size?: "big" | "normal";
    onClick?: () => void;
    imageUrl: string;
}

export const PestCard: FC<PestCardProps> = ({
    pest,
    className = "",
    size = "normal",
    onClick,
    imageUrl,
}) => {
    const { name, code } = pest;

    return (
        <div className={`w-full flex flex-row ${className}`} onClick={onClick}>
            <Image
                src={`${imageUrl}images/${code}.svg`}
                className={`${size === "normal" ? "w-12" : "w-20"} h-auto`}
            />

            <p
                className={`${
                    size === "big"
                        ? "text-4xl py-5 px-4 font-bold"
                        : "py-4 px-3"
                }`}
            >
                {name}
            </p>
        </div>
    );
};