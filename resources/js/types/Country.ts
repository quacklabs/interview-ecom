interface Country {
    countryName: string,
    countryShortCode: string,
    regions?: Region[]
}

interface Region {
    name: string,
    shortCode: string
}

export type { Country, Region }