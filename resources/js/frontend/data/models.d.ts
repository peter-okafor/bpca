import { PestInterface } from "./ProviderInterface";

export interface Pest {
    name: string;
    code: string;
}

export type pestGroup = {
    string: PestInterface[]
}

type ReviewType = {
    name: string;
    image: string;
    content: string;
    writer: string;
}

type ComponentContentType = {
    component: string;
    content: string;
}

type LinkType = {
    item: string;
    link: string;
}

type LocalityType = {
    name : string,
    description : string,
    // latlng : null,
}